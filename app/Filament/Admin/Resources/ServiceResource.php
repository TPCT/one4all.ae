<?php

namespace App\Filament\Admin\Resources;

use App\Exports\ServiceExport;
use App\Filament\Admin\Resources\ClientResource\Widgets\Client;
use App\Filament\Admin\Resources\ServiceResource\Pages;
use App\Filament\Admin\Resources\ServiceResource\RelationManagers;
use App\Filament\Components\FileUpload;
use App\Filament\Components\TextInput;
use App\Filament\Components\TinyEditor;
use App\Helpers\Utilities;
use App\Models\Dropdown\Dropdown;
use App\Models\Service;
use App\Models\Slider\Slider;
use CactusGalaxy\FilamentAstrotomic\Forms\Components\TranslatableTabs;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ServiceResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = Service\Service::class;

    protected static ?string $navigationIcon = 'carbon-settings-services';

    public static function getNavigationLabel(): string
    {
        return __("Services");
    }

    public static function getModelLabel(): string
    {
        return __("Service");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Services");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Services");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Custom Modules");
    }

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Grid::make()
                        ->schema([
                            TranslatableTabs::make()
                                ->localeTabSchema(fn (TranslatableTab $tab) => [
                                    FileUpload::make('image_id')
                                        ->multiple(false)
                                        ->label(__('Image')),

                                    TextInput::make($tab->makeName('title'))
                                        ->label(__("Title"))
                                        ->maxLength(255)
                                        ->required(),

                                    TinyEditor::make($tab->makeName("description"))
                                        ->label(__("Description")),

                                    TinyEditor::make($tab->makeName("content"))
                                        ->label(__("Content"))
                                ])->columnSpanFull()
                        ])
                        ->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_service') ? [
                                    Select::make('author.name')
                                        ->label(__("Author"))
                                        ->relationship('author', 'name')
                                        ->default(Filament::auth()->user()->id)
                                        ->required()
                                        ->native(false)
                                ] : [] , [
                                TextInput::make('slug')
                                    ->label(__("Slug"))
                                    ->unique(ignoreRecord: true)
                                    ->disabledOn('edit')
                                    ->helperText(__("Will Be Auto Generated From Title"))
                                    ->markAsRequired('true'),

                                Select::make('view_type')
                                    ->live()
                                    ->label(__("View type"))
                                    ->options(self::$model::getViewTypes())
                                    ->native(false)
                                    ->required(),

                                TextInput::make('price')
                                    ->maxLength(255)
                                    ->label(__('Price'))
                                    ->required(),

                                TranslatableTabs::make()
                                    ->localeTabSchema(fn (TranslatableTab $tab) => [
                                        TextInput::make($tab->makeName('youtube_video_id'))
                                            ->maxLength(255)
                                            ->label(__('Youtube Video')),
                                    ])
                                    ->visible(function (Forms\Get $get){
                                        return $get('data.view_type', true) == self::$model::VIEW_TYPE_3;
                                    })
                                    ->columnSpanFull(),

                                Select::make('slider_id')
                                    ->label(__('Slider'))
                                    ->relationship('slider', 'sliders_lang.title', modifyQueryUsing: function (Builder $query){
                                        $query->where('category', '=', Slider::SERVICE_SLIDER);
                                        $query->join('sliders_lang', 'sliders_lang.parent_id', '=', 'sliders.id')
                                            ->where('sliders_lang.language', '=', app()->getLocale());
                                    })
                                    ->visible(function (Forms\Get $get){
                                        return $get('data.view_type', true) == self::$model::VIEW_TYPE_1;
                                    })
                                    ->native(false)
                                    ->preload(),

                                Checkbox::make('promote_to_homepage')
                                    ->label(__('Promote To Homepage'))
                                    ->default(1),

                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__("Published At"))
                                    ->default(Carbon::today())
                                    ->native(false)
                                    ->required(),

                                Select::make('status')
                                    ->label(__("Status"))
                                    ->options(self::$model::getStatuses())
                                    ->native(false)
                                    ->default(1)
                            ])
                        )
                    ])->columnSpan(1),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function(){
                return self::$model::orderBy('created_at', 'desc');
            })
            ->columns([
                Tables\Columns\ImageColumn::make('image_id')
                    ->label(__("Image"))
                    ->toggleable()
                    ->getStateUsing(function ($record){
                        if ($record->image) {
                            return asset($record->image->url);
                        }
                        return asset('/storage/' . "panel-assets/no-image.png") ;
                    })
                    ->default(asset('/storage/' . "panel-assets/no-image.png"))
                    ->circular(),
                Tables\Columns\TextColumn::make('translation.title')
                    ->toggleable()
                    ->searchable(query: function ($query, $search){
                        return $query->whereTranslationLike('title', '%'.$search.'%');
                    })
                    ->label(__("Title")),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (Service\Service $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Service\Service $record){
                        return $record->status == Utilities::PUBLISHED ? __("Published") : __("Pending");
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->toggleable()
                    ->label(__("Publish Time"))
                    ->date(),
                Tables\Columns\TextColumn::make('author.name')
                    ->toggleable()
                    ->label(__("Author"))
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('author')
                    ->label(__("Author"))
                    ->searchable()
                    ->relationship('author', 'name')
                    ->native(false),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__("Status"))
                    ->options(self::$model::getStatuses())
                    ->searchable()
                    ->native(false)

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Add Client')
                        ->label(__('Add Client'))
                        ->icon('bi-person-fill')
                        ->form([
                            Select::make('client_id')
                            ->label(__('Client'))
                            ->options(function ($record){
                                return \App\Models\Client::whereDoesntHave('services', function ($query) use ($record){
                                    $query->where('service_id', $record->id);
                                })->orWhereHas('services', function ($query) use ($record){
                                    $query->where('service_id', $record->id);
                                    $query->where('client_services.expires_at', '<', Carbon::today()->toDateString());
                                })->get()->pluck('email', 'id');
                            })
                            ->native(false)
                            ->searchable()
                            ->required(),
                        ])
                        ->action(function ($data, $record){
                            $client = \App\Models\Client::find($data['client_id']);
                            $client->services()->attach($record->id, [
                                'expires_at' => Carbon::today()->addMonths(1)->toDateString(),
                            ]);
                            $client->update([
                                'joined' => 0
                            ]);
                        }),
                    Tables\Actions\Action::make(__('View Clients'))
                        ->icon('bi-person-fill')
                        ->modalContent(function ($record){
                            return view('filament.Services.table', ['record' => $record]);
                        })
                        ->modalHeading("")
                        ->modalCancelAction(false)
                        ->modalSubmitAction(false),
                ]),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->poll("60s")
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        ServiceExport::make()->fromModel()
                    ]),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
