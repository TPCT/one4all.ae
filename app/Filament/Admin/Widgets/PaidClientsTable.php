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

class PaidClientsTable extends BaseWidget
{
    use HasWidgetShield;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(function(){
                return Client::query()->where(function ($query) {
                    $query->whereHas('services', function ($query) {
                        $query->where('client_services.created_at', '=', Carbon::today()->toDateString());
                    })->orWhereHas('packages', function ($query) {
                        $query->where('client_packages.created_at', '=', Carbon::today()->toDateString());
                    });
                });
            })
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label(__("Name"))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__("Phone"))
                    ->searchable(),
                Tables\Columns\TextColumn::make("email")
                    ->label(__("Email"))
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('date')
                    ->form([
                        DatePicker::make('created_at')
                            ->label(__('Subscription Date'))
                            ->date()
                            ->native(false)
                    ])
                    ->query(function ($query) {
                        $query->whereHas('services', function ($query) {
                            $query->where('client_services.created_at', '=', Carbon::today()->toDateString());
                        });
                        $query->orWhereHas('packages', function ($query) {
                            $query->where('client_packages.created_at', '=', Carbon::today()->toDateString());
                        });
                    })
            ]);
    }
}
