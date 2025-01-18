<?php

namespace App\View\Components\Layout;

use App\Models\Menu\Menu;
use App\Settings\Site;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TopHeaderMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public ?Menu $menu = null;

    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.top-header-menu', [
            'telegram_link' => app(Site::class)->telegram_link
        ]);
    }
}
