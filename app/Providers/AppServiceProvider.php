<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $settings = Setting::query()->pluck('value', 'key');

        if ($settings->has('site_name')) {
            config()->set('app.name', $settings->get('site_name'));
        }

        if ($settings->has('mail_mailer')) {
            config()->set('mail.default', $settings->get('mail_mailer'));
        }

        if ($settings->has('mail_host')) {
            config()->set('mail.mailers.smtp.host', $settings->get('mail_host'));
        }

        if ($settings->has('mail_port')) {
            config()->set('mail.mailers.smtp.port', (int) $settings->get('mail_port'));
        }

        if ($settings->has('mail_username')) {
            config()->set('mail.mailers.smtp.username', $settings->get('mail_username'));
        }

        if ($settings->has('mail_password')) {
            config()->set('mail.mailers.smtp.password', $settings->get('mail_password'));
        }

        if ($settings->has('mail_encryption')) {
            config()->set('mail.mailers.smtp.encryption', $settings->get('mail_encryption'));
        }

        if ($settings->has('mail_from_address')) {
            config()->set('mail.from.address', $settings->get('mail_from_address'));
        }

        if ($settings->has('mail_from_name')) {
            config()->set('mail.from.name', $settings->get('mail_from_name'));
        }
    }
}
