<?php

namespace App\Filament\Admin\Resources\PaymentGatewayResource\Pages;

use App\Filament\Admin\Resources\PaymentGatewayResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\EditTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentGateway extends EditRecord
{
    use EditTranslatable;

    protected static string $resource = PaymentGatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
