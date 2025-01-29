<?php

namespace App\Filament\Admin\Resources\PaymentGatewayResource\Pages;

use App\Filament\Admin\Resources\PaymentGatewayResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\ListTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentGateways extends ListRecords
{
    use ListTranslatable;

    protected static string $resource = PaymentGatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
