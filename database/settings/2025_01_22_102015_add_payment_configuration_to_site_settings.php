<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.paypal_mode');
        $this->migrator->add('site.paypal_client_id');
        $this->migrator->add('site.paypal_client_secret');
        $this->migrator->add('site.paypal_app_id');
    }
};
