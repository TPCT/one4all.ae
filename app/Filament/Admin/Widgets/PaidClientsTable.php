<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Client;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\HtmlString;

class PaidClientsTable extends BaseWidget
{
    use HasWidgetShield;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(function(){
                return Client::query();
            })
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->getStateUsing(function ($record){
                        return $record->first_name.' '.$record->last_name;
                    })
                    ->label(__("Name"))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__("Phone"))
                    ->getStateUsing(function ($record){
                        return $record->country_code . $record->phone;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make("email")
                    ->label(__("Email"))
                    ->searchable(),

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
                            ->where(function ($query) {
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
            ])
            ->filters([
                Tables\Filters\Filter::make('date')
                    ->form([
                        DatePicker::make('created_at')
                            ->label(__('Subscription Date'))
                            ->date()
                            ->default(Carbon::today()->toDateString())
                            ->native(false)
                    ])
                    ->query(function ($query, $data) {
                        $query->when($data['created_at'], function ($query, $created_at) {
                            $created_at = Carbon::parse($created_at)->toDateString();
                            $query->where(function ($query) use ($created_at) {
                                $query->whereHas('services', function ($query) use ($created_at) {
                                    $query->whereDate('client_services.created_at', $created_at);
                                });
                            });
                            $query->orWhere(function ($query) use ($created_at) {
                                $query->whereHas('packages', function ($query) use ($created_at){
                                    $query->whereDate('client_packages.created_at', $created_at);
                                });
                            });
                        });
                    })
            ]);
    }
}
