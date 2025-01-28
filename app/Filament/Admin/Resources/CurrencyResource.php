<?php

namespace App\Filament\Admin\Resources;

use App\Exports\DistrictExport;
use App\Filament\Admin\Resources\CurrencyResource\Pages\CreateCurrency;
use App\Filament\Admin\Resources\CurrencyResource\Pages\EditCurrency;
use App\Filament\Admin\Resources\CurrencyResource\Pages\ListCurrencies;
use App\Filament\Admin\Resources\DistrictResource\Widgets\DistrictsWidget;
use App\Filament\Components\FileUpload;
use App\Filament\Components\TextInput;
use App\Helpers\Utilities;
use App\Models\City\City;
use App\Models\Currency;
use App\Models\District\District;
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

class CurrencyResource extends Resource
{
    use ResourceTranslatable;

    protected static ?string $model = Currency::class;

    protected static ?string $navigationIcon = 'bi-coin';

    public static function getNavigationLabel(): string
    {
        return __("Currencies");
    }

    public static function getModelLabel(): string
    {
        return __("Currency");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Currencies");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Currencies");
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
                    Forms\Components\Section::make()->schema([
                        FileUpload::make('image_id')
                            ->multiple(false)
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->label(__('Name'))
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('code')
                            ->label(__('Name'))
                            ->maxLength(255)
                            ->required(),
                    ])->columnSpan(2),
                    Forms\Components\Section::make()->schema(
                        array_merge(
                            Filament::auth()->user()->can('change_author_currency') ? [
                                Select::make('author.name')
                                    ->label(__("Author"))
                                    ->relationship('author', 'name')
                                    ->default(Filament::auth()->user()->id)
                                    ->required()
                                    ->native(false)
                            ] : [] , [
                            Forms\Components\DatePicker::make('published_at')
                                ->label(__("Published At"))
                                ->default(Carbon::today())
                                ->native(false)
                                ->required(),
                            Select::make('status')
                                ->label(__("Status"))
                                ->options(District::getStatuses())
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
                    ->searchable()
                    ->label(__("Title")),
                Tables\Columns\TextColumn::make('code')
                    ->label(__('Code'))
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable()
                    ->label(__("Status"))
                    ->badge()
                    ->color(function ($record){
                        return $record->status == Utilities::PUBLISHED ? "success" : "danger";
                    })
                    ->formatStateUsing(function($record){
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
                    ->options(City::getStatuses())
                    ->searchable()
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->poll('30s')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')
                        ->label(__('Export'))
                        ->exports([
                            DistrictExport::make()->fromModel()
                    ]),
                    Tables\Actions\DeleteBulkAction::make()
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
            'index' => ListCurrencies::route('/'),
            'create' => CreateCurrency::route('/create'),
            'edit' => EditCurrency::route('/{record}/edit'),
        ];
    }
}
