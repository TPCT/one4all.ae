<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\NewsletterResource\Pages;
use App\Filament\Admin\Resources\NewsletterResource\RelationManagers;
use App\Filament\Components\TextInput;
use App\Helpers\BaseExport;
use App\Helpers\HasForm;
use App\Models\ContactUs;
use App\Models\Dropdown\Dropdown;
use App\Models\Newsletter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class NewsletterResource extends Resource
{
    use HasForm, Translatable;

    protected static ?string $model = Newsletter::class;


    protected static ?string $navigationIcon = 'fas-city';


    public static function getNavigationLabel(): string
    {
        return __("Newsletter Forms");
    }

    public static function getModelLabel(): string
    {
        return __("Newsletter Form");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Newsletter Forms");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Newsletter Forms");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Forms");
    }

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function (){
                return self::$model::orderBy('created_at', 'desc');
            })
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->toggleable()
                    ->searchable()
                    ->label(__("email")),
                Tables\Columns\TextColumn::make("created_at")
                    ->label(__("Created At"))
                    ->toggleable()
                    ->since()
            ])
            ->filters([])
            ->actions([
                Tables\Actions\DeleteAction::make()
            ])
            ->poll('30s')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        BaseExport::make()->fromModel()
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
            'index' => Pages\ListNewsletters::route('/'),
        ];
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
