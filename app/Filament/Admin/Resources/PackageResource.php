<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PackageResource\Pages;
use App\Filament\Admin\Resources\PackageResource\RelationManagers;
use App\Filament\Components\TextInput;
use App\Filament\Components\TinyEditor;
use App\Helpers\Utilities;
use App\Models\Menu\Menu;
use App\Models\Package;
use App\Models\Service\Service;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PackageResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = Package\Package::class;

    protected static ?string $navigationIcon = 'zondicon-menu';

    public static function getNavigationLabel(): string
    {
        return __("Packages");
    }

    public static function getModelLabel(): string
    {
        return __("Package");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Packages");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Packages");
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
                Forms\Components\Grid::make(3)
                    ->schema([
                                Forms\Components\Grid::make()->schema([
                                    TranslatableTabs::make()
                                        ->localeTabSchema(fn (TranslatableTab $tab) => [
                                            Forms\Components\Section::make()->schema([
                                                TextInput::make($tab->makeName('title'))
                                                    ->label(__("Title"))
                                                    ->maxLength(255)
                                                    ->required(),

                                                TextInput::make($tab->makeName('discount'))
                                                    ->label(__("Discount"))
                                                    ->maxLength(255),

                                                TinyEditor::make($tab->makeName('description'))
                                                    ->label(__("Description"))
                                                    ->maxLength(255)
                                                    ->required(),
                                            ]),
                                ])->columnSpanFull(),
                                Forms\Components\Section::make()->schema([
                                    Forms\Components\Repeater::make('items')
                                        ->label(__("Items"))
                                        ->relationship()
                                        ->defaultItems(0)
                                        ->collapsible()
                                        ->collapsed()
                                        ->schema(function (){
                                            $tabs = [];
                                            foreach(config('app.locales') as $locale => $language){
                                                $tabs[] = Forms\Components\Tabs\Tab::make($language)
                                                    ->schema([
                                                        TextInput::make("{$locale}.title")
                                                            ->label(__("Title"))
                                                            ->maxLength(255)
                                                            ->required(),
                                                    ]);
                                            }
                                            return [Forms\Components\Tabs::make()->tabs($tabs)];
                                        })
                                        ->itemLabel(function ($state){
                                            return $state[app()->getLocale()]['title'] ?? __("UNKNOWN_SERVICE");
                                        })
                                ])
                        ])->columnSpan(2),
                        Forms\Components\Section::make()->schema(
                            array_merge(
                                Filament::auth()->user()->can('change_author_package') ? [
                                    Forms\Components\Select::make('author.name')
                                        ->label(__("Author"))
                                        ->relationship('author', 'name')
                                        ->default(Filament::auth()->user()->id)
                                        ->required()
                                        ->native(false)
                                ] : [] , [
                                Select::make('service_ids')
                                    ->label(__("Services"))
                                    ->multiple()
                                    ->preload()
                                    ->required()
                                    ->options(Service::active()->get()->pluck('title', 'id')->all()),

                                TextInput::make('months')
                                    ->label(__("Months"))
                                    ->integer()
                                    ->required()
                                    ->suffix(__("Month/s"))
                                    ->maxValue(12)
                                    ->minValue(1),

                                TextInput::make('price')
                                    ->label(__("Price"))
                                    ->integer()
                                    ->required()
                                    ->suffix(__("SAR"))
                                    ->minValue(1),

                                TextInput::make('slug')
                                    ->label(__("Slug"))
                                    ->unique(ignoreRecord: true)
                                    ->disabledOn('edit')
                                    ->helperText(__("Will Be Auto Generated From Title"))
                                    ->markAsRequired('true'),

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
                        )->columnSpan(1)
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
                Tables\Columns\TextColumn::make('title')
                    ->toggleable()
                    ->label(__("Title"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function (Package\Package $record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function(Package\Package $record){
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
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make(__('View Clients'))
                        ->icon('bi-person-fill')
                        ->modalContent(function ($record){
                            return view('filament.Packages.table', ['record' => $record]);
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
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
