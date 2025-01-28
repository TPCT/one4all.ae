<?php

namespace App\Filament\Admin\Resources\PackageResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClientStats extends BaseWidget
{
    public $record;

    protected function getStats(): array
    {
        $package = $this->record;

        return [
            Stat::make(__("Subscribed Clients"), function() use ($package) {
                return \App\Models\Client::where('active', true)
                    ->where(function (\Illuminate\Database\Eloquent\Builder $builder) use ($package) {
                        $builder->whereHas('packages', function (\Illuminate\Database\Eloquent\Builder $builder) use ($package) {
                            $builder->where('package_id', $package->id);
                        });
                    })->count();
            })->icon('bi-person-fill'),
            Stat::make(__("Un-Subscribed Clients"), function() use ($package) {
                return \App\Models\Client::where('active', true)
                    ->where(function (\Illuminate\Database\Eloquent\Builder $builder) use ($package) {
                        $builder
                            ->whereDoesntHave('packages')
                            ->orWhereHas('packages', function (\Illuminate\Database\Eloquent\Builder $builder) use ($package) {
                                $builder->where('package_id', '!=', $package->id);
                            });
                    })->count();
            })->icon('bi-person-fill'),
        ];
    }
}
