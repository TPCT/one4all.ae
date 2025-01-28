<?php

namespace App\Filament\Admin\Resources\ServiceResource\Widgets;

use App\Exports\ClientExport;
use App\Models\Client;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Query\Builder;
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
            ])
            ->poll('60s')
            ->filters([
                Tables\Filters\Filter::make('expiration_date')
                    ->form([
                        DatePicker::make('expires_at')
                            ->label(__('Expiration date'))
                            ->default(Carbon::today())
                            ->native(false),
                        Select::make('joined')
                            ->options([
                                "0" => __("Not joined"),
                                "1" => __("Joined"),
                            ])
                            ->default("0")
                            ->label(__('Joined'))
                            ->searchable()
                            ->native(false)
                    ])
                    ->query(function ($query, $data) {
                        $query->when($data['expires_at'], function ($query, $expires_at) {
                            $query->whereHas('services', function ($query) use ($expires_at) {
                                $query->where('client_services.expires_at', '>=', Carbon::parse($expires_at)->toDateTimeString());
                            });
                        });
                        $query->when($data['joined'], function ($query, $joined) {
                            $query->where('joined', $joined == "1");
                        });
                    })
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(__('Delete')),
                Tables\Actions\Action::make('joined')
                    ->label(function ($record) {
                        return $record->joined ? __('Removed') : __('Joined');
                    })
                    ->action(fn($record) => $record->update(['joined' => !$record->joined]))
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
