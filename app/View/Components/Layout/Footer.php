<?php

namespace App\View\Components\Layout;

use App\Models\Branch\Branch;
use App\Models\Currency;
use App\Models\Dropdown\Dropdown;
use App\Models\Menu\Menu;
use App\Models\PaymentGateway\PaymentGateway;
use App\Settings\General;
use App\Settings\Site;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{

    public ?Menu $menu;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->menu = Menu::where([
            'category' => Menu::FOOTER_MENU,
        ])->active()->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $newsletter_section = Dropdown::active()->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('homepage-newsletter-section')
            ->first()
            ?->blocks()
            ?->first();

        $payment_gateways = PaymentGateway::active()->limit(5)->get();
        return view('components.layout.footer', [
            'facebook' => app(Site::class)->facebook_link,
            'twitter' => app(Site::class)->twitter_link,
            'instagram' => app(Site::class)->instagram_link,
            'youtube' => app(Site::class)->youtube_link,
            'linkedin' => app(Site::class)->linkedin_link,
            'logo' => session('mode') === 'dark' ? app(Site::class)->dark_logo : app(Site::class)->logo,
            'footer_description' => app(Site::class)->footer_description[app()->getLocale()],
            'newsletter_section' => $newsletter_section,
            'payment_gateways' => $payment_gateways,
        ]);
    }
}
