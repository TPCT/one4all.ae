<?php

namespace App\View\Components\Layout;

use App\Models\Client;
use App\Models\Menu\Menu;
use App\Settings\Site;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public ?Menu $menu;
    public ?Client $client;
    public ?string $logo;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->menu = Menu::where([
            'category' => Menu::HEADER_MENU,
        ])->active()->first();
        $this->client = \Auth::guard('clients')->user();
        $this->logo = session('mode') === 'dark' ? app(Site::class)->dark_logo : app(Site::class)->logo;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.header');
    }
}
