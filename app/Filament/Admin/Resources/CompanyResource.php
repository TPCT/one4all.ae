<?php

namespace App\Filament\Admin\Resources;

use App\Exports\BlockExport;
use App\Exports\CompanyExport;
use App\Filament\Admin\Resources\CompanyResource\Pages;
use App\Filament\Admin\Resources\CompanyResource\RelationManagers;
use App\Filament\Components\FileUpload;
use App\Filament\Components\TextInput;
use App\Filament\Components\TinyEditor;
use App\Helpers\Utilities;
use App\Models\Company;
use CactusGalaxy\FilamentAstrotomic\Forms\Components\TranslatableTabs;
use CactusGalaxy\FilamentAstrotomic\Resources\Concerns\ResourceTranslatable;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CompanyResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = Company\Company::class;

    protected static ?string $navigationIcon = 'carbon-location-company-filled';

    public static function getNavigationLabel(): string
    {
        return __("Companies");
    }

    public static function getModelLabel(): string
    {
        return __("Company");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Companies");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Companies");
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
                                        ->label(__("Description"))
                                ])->columnSpanFull()
                        ])
                        ->columnSpan(2),
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_company') ? [
                                    Select::make('author.name')
                                        ->label(__("Author"))
                                        ->relationship('author', 'name')
                                        ->default(Filament::auth()->user()->id)
                                        ->required()
                                        ->native(false)
                                ] : [] , [
                                TextInput::make('url')
                                    ->label(__('URL'))
                                    ->maxLength(255)
                                    ->required(),
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
                    ->color(function (Company\Company $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Company\Company $record){
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->poll("60s")
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        CompanyExport::make()->fromModel()
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
