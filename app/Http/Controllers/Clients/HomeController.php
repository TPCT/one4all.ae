<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\Block\Block;
use App\Models\Branch\Branch;
use App\Models\Category\Category;
use App\Models\ContactUs;
use App\Models\Dropdown\Dropdown;
use App\Models\Merchant\Merchant;
use App\Models\Page\Page;
use App\Models\Service\Service;
use App\Models\Slider\Slider;
use App\Models\Slider\SliderSlide;
use App\Settings\Site;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Validator;
use function request;

class HomeController extends Controller
{
    public function index()
    {
        $hero_slider = Slider::active()
            ->whereCategory(Slider::HERO_SECTION_SLIDER)
            ->first();
        $about_us_section = Dropdown::active()->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('homepage-about-us-section'
            )->first()
            ?->blocks()
            ?->first();
        $services = Service::where('promote_to_homepage', 1)->latest()->limit(10)->get();
        return $this->view('site.homepage', [
            'hero_slider' => $hero_slider,
            'about_us_section' => $about_us_section,
            'services' => $services,
        ]);
    }
}
