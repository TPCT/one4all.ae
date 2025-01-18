<?php

namespace App\Filament\Admin\Resources\ServiceResource\Pages;

use App\Filament\Admin\Resources\ServiceResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\ListTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServices extends ListRecords
{
    use ListTranslatable;

    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
