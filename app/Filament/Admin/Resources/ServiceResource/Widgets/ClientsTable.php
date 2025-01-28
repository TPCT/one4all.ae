<?php

namespace App\Filament\Admin\Resources\ServiceResource\Widgets;

use App\Exports\ClientExport;
use App\Models\Client;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\HtmlString;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ClientsTable extends BaseWidget
{
    public $record;

    public function table(Table $table): Table
    {
        $service = $this->record;
        return $table
            ->query(function() use ($service){
                return Client::whereHas('services', function ($query) use ($service) {
                    $query->where('service_id', $service->id);
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
                Tables\Columns\TextColumn::make('packages')
                    ->label(__('Packages'))
                    ->getStateUsing(function (Client $client) {
                        $package = $client->packages()->latest()->withPivot('created_at')->first();
                        if ($package && Carbon::parse($package->pivot->created_at)->addMonths($package->months) > Carbon::now())
                            return $package->title;
                        return "------";
                    })
            ])
            ->poll('60s')
            ->filters([
//                Tables\Filters\Filter::make('subscription')
//                    ->form([
//                        Forms\Components\Checkbox::make('active_packages')
//                            ->label(__('Active Packages')),
//                        Forms\Components\Checkbox::make('active_services')
//                            ->label(__('Active Services')),
//                    ])
//                    ->query(function (Builder $query, $data) {
//                        $query->when($data['active_packages'], function (Builder $query) {
//                            $query->whereHas('packages', function (Builder $query) {
//                                $query->where(function ($query) {
//                                    $query->where('expires_at', '>', Carbon::now());
//                                });
//                            });
//                        })
//                            ->when($data['active_services'], function (Builder $query) {
//                                $query->whereHas('services', function (Builder $query) {
//                                    $query->where(function ($query) {
//                                        $query->where('expires_at', '>', Carbon::now());
//                                    });
//                                });
//                            });
//                    })
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
}
