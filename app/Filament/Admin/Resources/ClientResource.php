<?php

namespace App\Filament\Admin\Resources;

use App\Exports\ClientExport;
use App\Exports\MerchantExport;
use App\Filament\Admin\Resources\ClientResource\Pages;
use App\Filament\Admin\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use App\Models\Package\Package;
use Carbon\Carbon;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'bi-person-fill';

    public static function getNavigationLabel(): string
    {
        return __("Clients");
    }

    public static function getModelLabel(): string
    {
        return __("Clients");
    }

    public static function getPluralLabel(): ?string
    {
        return __("Clients");
    }

    public static function getPluralModelLabel(): string
    {
        return __("Clients");
    }

    public static function getNavigationGroup(): ?string
    {
        return __("Clients");
    }

    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function(){
                return self::$model::orderBy('created_at', 'desc');
            })
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__("Name"))
                    ->getStateUsing(function (Client $client) {
                        return $client->first_name . " " . $client->last_name;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->getStateUsing(function(Client $record){
                        return $record->country_code . $record->phone;
                    })
                    ->searchable(query: function ($query, $search) {
                        return $query->orWhere('phone', 'LIKE', "%{$search}%");
                    }),
                Tables\Columns\TextColumn::make('packages')
                    ->label(__('Packages'))
                    ->getStateUsing(function (Client $client) {
                        $package = $client->packages()->latest()->withPivot('created_at')->first();
                        if ($package && Carbon::parse($package->pivot->created_at)->addMonths($package->months) > Carbon::now())
                            return $package->title;
                        return "------";
                    }),
                Tables\Columns\TextColumn::make('services')
                    ->label(__('Services'))
                    ->limit(25)
                    ->html()
                    ->getStateUsing(function (Client $client) {
                        return $client->services()
                            ->withPivot('created_at')
                            ->where(function (Builder $query) {
                                $query->where('client_services.created_at', '>', Carbon::today()->subMonth()->toDateString());
                            })
                            ->get()->pluck('title')->toArray() ?: ['---------'];
                    })
                    ->extraAttributes(function ($state){
                        return [
                            'x-tooltip.html' => new HtmlString(),
                            'x-tooltip.raw' => new HtmlString(implode('<br> ', $state ?? [])),
                        ];
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->since()
            ])
            ->poll('60s')
            ->filters([
                Tables\Filters\Filter::make('subscription')
                    ->form([
                        Forms\Components\Checkbox::make('active_packages')
                            ->label(__('Active Packages')),
                        Forms\Components\Checkbox::make('active_services')
                            ->label(__('Active Services')),
                    ])
                    ->query(function (Builder $query, $data) {
                        $query->when($data['active_packages'], function (Builder $query) {
                            $query->whereHas('packages', function (Builder $query) {
                                $query->where(function ($query) {
                                    $query->where('expires_at', '>', Carbon::now());
                                });
                            });
                        })
                        ->when($data['active_services'], function (Builder $query) {
                            $query->whereHas('services', function (Builder $query) {
                                $query->where(function ($query) {
                                    $query->where('expires_at', '>', Carbon::now());
                                });
                            });
                        });
                    })
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(__('Delete')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make('Export')->label(__('Export'))->exports([
                        ClientExport::make()->fromModel()
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // TODO: Change the autogenerated stub
    }

    public static function canEdit(Model $record): bool
    {
        return false; // TODO: Change the autogenerated stub
    }
}
