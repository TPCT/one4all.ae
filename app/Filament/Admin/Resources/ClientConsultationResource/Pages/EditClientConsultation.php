<?php

namespace App\Filament\Admin\Resources\ClientConsultationResource\Pages;

use App\Filament\Admin\Resources\ClientConsultationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientConsultation extends EditRecord
{
    protected static string $resource = ClientConsultationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
