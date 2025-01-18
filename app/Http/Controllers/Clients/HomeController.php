<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\Branch\Branch;
use App\Models\Category\Category;
use App\Models\ContactUs;
use App\Models\Merchant\Merchant;
use App\Models\Page\Page;
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
        return $this->view('site.homepage', [
            'hero_slider' => $hero_slider,
        ]);
    }
}
