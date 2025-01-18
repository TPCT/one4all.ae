<?php

namespace App\Filament\Admin\Resources\ServiceResource\Pages;

use App\Filament\Admin\Resources\ServiceResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\CreateTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    use CreateTranslatable;
    protected static string $resource = ServiceResource::class;
}
