<?php

namespace Cachet\Database\Seeders;

use Cachet\Settings\AppSettings;
use Cachet\Settings\BrandingSettings;
use Cachet\Settings\CustomizationSettings;
use Cachet\Settings\ThemeSettings;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;

/**
 * Uc seeder.
 *
 * No demo data is created.
 */
class UcSetupSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedUser();
        $this->call(UptimeKumaTemplatesSeeder::class);
        $this->seedSettings();
    }

    /**
     * Create the default admin user.
     */
    protected function seedUser(): void
    {
        /** @var User $userModel */
        $userModel = config('cachet.user_model');

        $userModel::firstOrCreate(
            ['email' => 'test@test.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('test123'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );
    }

    protected function seedSettings(): void
    {
        //settings to seed
        $appSettings = app(AppSettings::class);
        $appSettings->name = 'United Codes Status';
        $appSettings->about = 'status and incident reporting services.';
        $appSettings->show_support = false;
        $appSettings->timezone = 'UTC';
        $appSettings->show_timezone = false;
        $appSettings->only_disrupted_days = false;
        $appSettings->incident_days = 7;
        $appSettings->refresh_rate = null;
        $appSettings->dashboard_login_link = true;
        $appSettings->major_outage_threshold = 25;
        $appSettings->recent_incidents_only = false;
        $appSettings->recent_incidents_days = 7;
        $appSettings->save();
        $customizationSettings = app(CustomizationSettings::class);
        $customizationSettings->header = '';
        $customizationSettings->footer = '';
        $customizationSettings->stylesheet = '';
        $customizationSettings->save();
        $themeSettings = app(ThemeSettings::class);
        $themeSettings->app_banner = '';
        $themeSettings->accent = 'cachet';
        $themeSettings->accent_content = 'zinc';
        $themeSettings->accent_pairing = true;
        $themeSettings->save();
    }
}
