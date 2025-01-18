<?php

namespace App\Filament\Admin\Resources\CompanyResource\Pages;

use App\Filament\Admin\Resources\CompanyResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\CreateTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCompany extends CreateRecord
{
    use CreateTranslatable;
    protected static string $resource = CompanyResource::class;
}
