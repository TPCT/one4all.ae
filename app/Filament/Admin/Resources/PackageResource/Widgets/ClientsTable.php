<?php

namespace App\Filament\Admin\Resources\PackageResource\Widgets;

use App\Exports\ClientExport;
use App\Models\Client;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ClientsTable extends BaseWidget
{
    public $record;

    public function table(Table $table): Table
    {
        $package = $this->record;
        return $table
            ->query(function() use ($package){
                return Client::whereHas('packages', function ($query) use ($package) {
                    $query->where('package_id', $package->id);
                    $query->where('client_packages.expires_at', Carbon::today()->toDateString());
                });
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
                Tables\Columns\TextColumn::make('expires_at')
                    ->label(__('Expires at'))
                    ->getStateUsing(function (Client $client) use ($package) {
                        return $client
                            ->packages()
                            ->where('package_id', $package->id)
                            ->withPivot('expires_at')
                            ->first()->pivot->expires_at;
                    })
                    ->date()
            ])
            ->poll('60s')
            ->filters([
                Tables\Filters\Filter::make('expiration_date')
                    ->form([
                        DatePicker::make('expires_at')
                            ->label(__('Expiration/Subscription date'))
                            ->default(null)
                            ->native(false),
                        Select::make('joined')
                            ->options([
                                "-1" => __("Not joined"),
                                "1" => __("Joined"),
                            ])
                            ->default("-1")
                            ->label(__('Joined'))
                            ->searchable()
                            ->native(false)
                    ])
                    ->query(function ($query, $data) use ($package) {
                        $query->when($data['expires_at'], function ($query, $expires_at) use ($package) {
                            $query->where(function ($query) use ($expires_at, $package) {
                                $query->whereHas('packages', function ($query) use ($expires_at, $package) {
                                    $query->where('client_packages.package_id', $package->id);
                                    $query->where('client_packages.created_at', Carbon::parse($expires_at)->toDateString());
                                    $query->orWhere('client_packages.expires_at', Carbon::parse($expires_at)->toDateString());
                                });
                            });
                        });
                        $query->when($data['joined'], function ($query, $joined) use ($package) {
                            $query->whereHas('packages', function ($query) use ($joined, $package) {
                                $query->where('client_packages.package_id', $package->id);
                                $query->where('client_packages.joined', $joined == "1");
                            });
                        });

                        return $query;
                    })
            ])
            ->actions([
                Tables\Actions\Action::make('joined')
                    ->label(function ($record) use ($package) {
                        return $record
                            ->packages()
                            ->where('packaged_id', $package->id)
                            ->first()
                            ->pivot
                            ->joined ? __("Remove") : __("Add");
                    })
                    ->action(function ($record) use ($package) {
                        $package = $record->services()->where('package_id', $package->id)->first();
                        $package->pivot->joined = !$package->pivot->joined;
                        $package->pivot->save();
                    }),
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
}
