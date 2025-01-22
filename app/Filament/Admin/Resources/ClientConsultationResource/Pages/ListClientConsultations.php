<?php

namespace App\Filament\Admin\Resources\ClientConsultationResource\Pages;

use App\Filament\Admin\Resources\ClientConsultationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientConsultations extends ListRecords
{
    protected static string $resource = ClientConsultationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
