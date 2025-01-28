<?php

namespace App\Filament\Admin\Resources\ServiceResource\Widgets;

use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClientsStat extends BaseWidget
{
    public $record;

    protected function getStats(): array
    {
        $service = $this->record;

        return [
            Stat::make(__("Subscribed Clients"), function() use ($service) {
                return \App\Models\Client::where('active', true)
                    ->where(function (\Illuminate\Database\Eloquent\Builder $builder) use ($service) {
                        $builder->whereHas('services', function (\Illuminate\Database\Eloquent\Builder $builder) use ($service) {
                            $builder->where('service_id', $service->id);
                            $builder->where('client_services.expires_at', '>', Carbon::today()->toDateString());
                        });
                    })->count();
            })->icon('bi-person-fill'),
            Stat::make(__("Un-Subscribed Clients"), function() use ($service) {
                return \App\Models\Client::where('active', true)
                    ->where(function (\Illuminate\Database\Eloquent\Builder $builder) use ($service) {
                        $builder
                            ->whereDoesntHave('services')
                            ->orWhereHas('services', function (\Illuminate\Database\Eloquent\Builder $builder) use ($service) {
                                $builder->where('service_id', '!=', $service->id);
                                $builder->where('client_services.expires_at', '<', Carbon::today()->toDateString());
                            });
                    })->count();
            })->icon('bi-person-fill'),
        ];
    }
}
