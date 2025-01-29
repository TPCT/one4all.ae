<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\Dropdown\Dropdown;
use App\Models\Faq\Faq;
use App\Models\Newsletter;
use App\Models\Package\Package;
use App\Models\Service\Service;
use App\Models\Slider\Slider;
use App\Models\Testimonial;
use Carbon\Carbon;

class SiteController extends Controller
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
        $services = Service::where('promote_to_homepage', true)->latest()->limit(10)->get();

        $has_button = true;
        if (auth()->guard('clients')->check()) {
            $client = auth()->guard('clients')->user();
            $package = $client->packages()->latest()->first();
            if ($package && Carbon::parse($package->pivot->created_at)->addMonths($package->months) > Carbon::today())
                $has_button = false;
        }
        $packages = Package::active()->latest()->limit(3)->get();

        $faqs_section = Dropdown::active()->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('homepage-faqs-section')
            ->first()
            ?->blocks()
            ?->first();

        $faqs = Faq::active()->latest()->limit(5)->get();

        $testimonials_section = Dropdown::active()->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('homepage-testimonials-section')
            ->first()
            ?->blocks()
            ?->first();

        $testimonials = Testimonial::active()->latest()->limit(10)->get();

        $newsletter_section = Dropdown::active()->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('homepage-newsletter-section')
            ->first()
            ?->blocks()
            ?->first();

        return $this->view('site.homepage', [
            'hero_slider' => $hero_slider,
            'about_us_section' => $about_us_section,
            'services' => $services,
            'packages' => $packages,
            'faqs_section' => $faqs_section,
            'faqs' => $faqs,
            'testimonials_section' => $testimonials_section,
            'testimonials' => $testimonials,
            'newsletter_section' => $newsletter_section,
            'has_button' => $has_button,
        ]);
    }

    public function aboutUs(){
        $about_us_section = Dropdown::active()
            ->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('about-us-page')
            ->first()
            ?->blocks()
            ?->first();
        return $this->view('site.about-us', [
            'about_us_section' => $about_us_section,
        ]);
    }

    public function newsletter(){
        $validation = [
            'email' => 'required|email'
        ];

        $data = request()->only(array_keys($validation));
        $validator = \Validator::make($data, $validation);
        if ($validator->fails())
            return Responses::error([], 422, implode(", ", array_values($validator->errors()->all(''))));
        $newsletter = Newsletter::where('email', $data['email'])->first();
        if ($newsletter)
            return Responses::error([], 422, __("errors.newsletter_already_exists"));
        Newsletter::create(['email' => $data['email']]);
        return Responses::success([], 200, __("site.newsletter_successfully_added"));
    }

    public function mode($locale, $mode){
        if ($mode == "dark"){
            session()->put('mode', 'dark');
            return back();
        }

        session()->put('mode', 'light');
        return back();
    }
}
