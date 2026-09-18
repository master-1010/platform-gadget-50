<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Application services are registered here.
    }

    public function boot(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        $settings = Setting::query()->pluck('value', 'key');

        $this->setIfPresent('app.name', $settings, 'site_name');
        $this->setIfPresent('mail.default', $settings, 'mail_mailer');
        $this->setIfPresent('mail.mailers.smtp.host', $settings, 'mail_host');
        $this->setIfPresent('mail.mailers.smtp.port', $settings, 'mail_port', fn ($value) => (int) $value);
        $this->setIfPresent('mail.mailers.smtp.username', $settings, 'mail_username');
        $this->setIfPresent('mail.mailers.smtp.password', $settings, 'mail_password', fn ($value) => Setting::getValue('mail_password'));
        $this->setIfPresent('mail.mailers.smtp.encryption', $settings, 'mail_encryption');
        $this->setIfPresent('mail.from.address', $settings, 'mail_from_address');
        $this->setIfPresent('mail.from.name', $settings, 'mail_from_name');
    }

    private function setIfPresent(string $configKey, $settings, string $settingKey, ?callable $transform = null): void
    {
        if (! $settings->has($settingKey)) {
            return;
        }

        $value = $transform ? $transform($settings->get($settingKey)) : $settings->get($settingKey);
        config()->set($configKey, $value);
    }
}
