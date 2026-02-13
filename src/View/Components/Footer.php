<?php

namespace Cachet\View\Components;

use Cachet\Cachet;
use Cachet\Settings\AppSettings;
use Cachet\Settings\BrandingSettings;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(private AppSettings $appSettings)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $brandingFooterBgColor = null;
        $brandingFooterTextColor = null;
        $brandingFooterCopyright = null;
        $brandingShowCachetBranding = true;
        $brandingFooterLinks = [];

        try {
            $branding = app(BrandingSettings::class);
            $brandingFooterBgColor = $branding->footer_bg_color;
            $brandingFooterTextColor = $branding->footer_text_color;
            $brandingFooterCopyright = $branding->footer_copyright;
            $brandingShowCachetBranding = $branding->show_cachet_branding;
            $brandingFooterLinks = $branding->getFooterLinks();
        } catch (\Throwable) {
            
        }

        return view('cachet::components.footer', [
            'showSupport' => $brandingShowCachetBranding && $this->appSettings->show_support,
            'cachetVersion' => Cachet::version(),
            'showTimezone' => $this->appSettings->show_timezone,
            'timezone' => $this->appSettings->timezone,
            'siteName' => $this->appSettings->name ?: config('cachet.title', 'Status Page'),
            'brandingFooterBgColor' => $brandingFooterBgColor,
            'brandingFooterTextColor' => $brandingFooterTextColor,
            'brandingFooterCopyright' => $brandingFooterCopyright,
            'brandingFooterLinks' => $brandingFooterLinks,
        ]);
    }
}
