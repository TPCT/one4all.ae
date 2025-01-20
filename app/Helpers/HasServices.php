<?php

namespace App\Helpers;

use App\Models\Section;
use App\Models\Service\Service;

trait HasServices
{
    public function initializeHasServices(){
        $this->append('service_ids');
    }

    public function getServiceIdsAttribute(): ?array
    {
        $servicesIds = [];
        foreach (request('components.0.updates', []) as $key => $value){
            if (str_starts_with($key, 'data.service_ids.') && is_numeric($value))
                $servicesIds[] = $value;
        }
        return $servicesIds ?: $this->services()->pluck('service_id')->all();
    }

    public static function bootHasServices(): void{
        self::creating(function ($model) {
            $model->services()->sync($model->service_ids);
        });

        self::saving(function ($model) {
            $model->services()->sync($model->service_ids);
        });

        self::deleting(function ($model) {
            $model->services()->detach();
        });
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'package_services');
    }
}
