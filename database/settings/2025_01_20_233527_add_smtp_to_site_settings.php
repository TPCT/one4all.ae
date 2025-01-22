<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.smtp_server');
        $this->migrator->add('site.smtp_port');
        $this->migrator->add('site.smtp_encryption');
        $this->migrator->add('site.smtp_username');
        $this->migrator->add('site.smtp_password');
        $this->migrator->add('site.smtp_from_address');
        $this->migrator->add('site.smtp_from_name');
    }
};
