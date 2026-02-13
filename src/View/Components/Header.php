<?php

namespace Cachet\View\Components;

use Cachet\Settings\AppSettings;
use Cachet\Settings\BrandingSettings;
use Cachet\Settings\ThemeSettings;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(private AppSettings $appSettings, private ThemeSettings $themeSettings)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $brandingLogo = null;
        $brandingLogoHeight = 32;
        $brandingHeaderBgColor = null;
        $brandingHeaderTextColor = null;
        $brandingHeaderLinks = [];
        $brandingShowSubscribe = true;
        $brandingShowDashboardLink = true;

        try {
            $branding = app(BrandingSettings::class);
            $brandingLogo = $branding->header_logo;
            $brandingLogoHeight = $branding->header_logo_height ?? 32;
            $brandingHeaderBgColor = $branding->header_bg_color;
            $brandingHeaderTextColor = $branding->header_text_color;
            $brandingHeaderLinks = $branding->getHeaderLinks();
            $brandingShowSubscribe = $branding->show_subscribe_button;
            $brandingShowDashboardLink = $branding->show_dashboard_link;
        } catch (\Throwable) {
        }

        return view('cachet::components.header', [
            'siteName' => $this->appSettings->name,
            'appBanner' => $this->themeSettings->app_banner,
            'dashboardLoginLink' => $brandingShowDashboardLink && $this->appSettings->dashboard_login_link,
            'brandingLogo' => $brandingLogo,
            'brandingLogoHeight' => $brandingLogoHeight,
            'brandingHeaderBgColor' => $brandingHeaderBgColor,
            'brandingHeaderTextColor' => $brandingHeaderTextColor,
            'brandingHeaderLinks' => $brandingHeaderLinks,
            'brandingShowSubscribe' => $brandingShowSubscribe,
        ]);
    }
}
