<?php

namespace App\Filament\Admin\Resources\PaymentGatewayResource\Pages;

use App\Filament\Admin\Resources\PaymentGatewayResource;
use CactusGalaxy\FilamentAstrotomic\Resources\Pages\Record\CreateTranslatable;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentGateway extends CreateRecord
{
    use CreateTranslatable;
    protected static string $resource = PaymentGatewayResource::class;
}
