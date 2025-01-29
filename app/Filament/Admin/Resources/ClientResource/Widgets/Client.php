<?php

namespace App\Filament\Admin\Resources\ClientResource\Widgets;

use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Query\Builder;

class Client extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__("Clients"), function (){
                return \App\Models\Client::count();
            })->icon('bi-person-fill'),
            Stat::make(__("Subscribed Clients"), function(){
                return \App\Models\Client::where('active', true)
                    ->where(function (\Illuminate\Database\Eloquent\Builder $builder){
                        $builder->whereHas('services');
                        $builder->orWhereHas('packages');
                    })->count();
            })->icon('bi-person-fill'),
            Stat::make(__("Un-Subscribed Clients"), function(){
                return \App\Models\Client::where('active', true)
                    ->where(function (\Illuminate\Database\Eloquent\Builder $builder){
                        $builder->whereDoesntHave('packages');
                        $builder->whereDoesntHave('services');
                    })->count();
            })->icon('bi-person-fill'),
        ];
    }
}
