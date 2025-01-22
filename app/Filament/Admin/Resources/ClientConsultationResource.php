<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ClientConsultationResource\Pages\ListClientConsultations;
use App\Filament\Admin\Resources\ContactUsResource\Pages\ListContactUs;
use App\Filament\Components\TextInput;
use App\Helpers\BaseExport;
use App\Helpers\HasForm;
use App\Models\ClientConsultation;
use App\Models\ContactUs;
use App\Models\Dropdown\Dropdown;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ClientConsultationResource extends Resource implements HasShieldPermissions
{
    use HasForm, Translatable;

    protected static ?string $model = ClientConsultation::class;


    protected static ?string $navigationIcon = 'fas-city';


    public static function getNavigationLabel(): string
    {
        return __("Client Consultation Forms");
    }

    public static function getModelLabel(): string
    {
        return __("Client Consultation Form");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Client Consultation Forms");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Client Consultation Forms");
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
                Tables\Columns\TextColumn::make("dropdown_id")
                    ->label(__("Consultation Type"))
                    ->formatStateUsing(function ($record){
                        return Dropdown::find($record->dropdown_id)->title;
                    })
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->label(__("Name")),
                Tables\Columns\TextColumn::make("email")
                    ->toggleable()
                    ->label(__("Email")),
                Tables\Columns\TextColumn::make("whatsapp")
                    ->label(__("whatsapp"))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('date')
                    ->label(__("Date"))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('time')
                    ->label(__("Time"))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('paid')
                    ->badge()
                    ->color(function ($client){
                        return $client->paid ? "success" : "danger";
                    })
                    ->formatStateUsing(function ($record){
                        return $record->paid ? __("Paid") : __("Not Paid");
                    })
                    ->label(__("Paid"))
                    ->toggleable(),

                Tables\Columns\TextColumn::make("created_at")
                    ->label(__("Created At"))
                    ->toggleable()
                    ->since()
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->form([
                        TextInput::make('name')
                            ->label(__("Name")),
                        TextInput::make('email')
                            ->label(__("Email")),
                        TextInput::make('whatsapp')
                            ->label(__("whatsapp")),
                        Checkbox::make('paid')
                            ->label(__("Paid"))
                            ->default(1),
                        Checkbox::make('up_coming')
                            ->default(1)
                            ->label(__("Up Coming"))
                    ])
                    ->query(function (Builder $query, array $data){
                        $query->when(
                            $data['name'],
                            fn (Builder $builder, $name) => $query->where('name', 'like', '%' . $name . '%'));
                        $query->when(
                            $data['email'],
                            fn (Builder $builder, $email) => $query->where('email', 'like', '%' . $email . '%'));
                        $query->when(
                            $data['whatsapp'],
                            fn (Builder $builder, $whatsapp) => $query->where('whatsapp', 'like', '%' . $whatsapp . '%'));
                        $query->when($data['paid'], fn (Builder $builder, $paid) => $query->where('paid', $paid));
                        $query->when($data['up_coming'], fn (Builder $builder, $up_coming) => $query->where('done', !$up_coming));
                    })
            ])
            ->actions([
                Tables\Actions\Action::make('notes')
                    ->label(__("Notes"))
                    ->modalHeading(function($record){
                        return "{$record->name} " . __("Notes");
                    })
                    ->modalContent(function ($record){
                        return view('filament.Consultation.Message', ['record' => $record]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false),
                Tables\Actions\Action::make('accept')
                    ->label(__("Accept"))
                    ->action(fn($record) => $record->update(['done' => true])),
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
            'index' => ListClientConsultations::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return False;
    }

    public static function canEdit(Model $record): bool
    {
        return False;
    }
}
