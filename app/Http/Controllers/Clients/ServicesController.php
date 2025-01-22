<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\ClientConsultation;
use App\Models\Dropdown\Dropdown;
use App\Models\Service\Service;
use App\Settings\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal;

class ServicesController extends Controller
{
    public function show($locale, Service $service){
        $slider = $service->slider;
        $form_choices = Dropdown::active()->whereCategory(Dropdown::CONSULTATION_CATEGORY)->get();
        $has_button = true;

        if (auth()->guard('clients')->check()){
            $client = auth()->guard('clients')->user();
            $subscription = $client->services()->where('service_id', $service->id)->where(function ($query){
                $query->where('client_services.created_at', '>', Carbon::today()->subMonth()->format('Y-m-d'));
            })->first();

            if ($subscription)
                $has_button = false;

            $package = $client->packages()->latest()->first();
            if ($package && Carbon::parse($package->pivot->created_at)->addMonths($package->months) > Carbon::today()){
                if ($package->services->contains($service->id))
                    $has_button = false;
            }
        }

        if ($service->has_form && \request()->isMethod('POST')){
            $data = \request()->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'whatsapp' => 'required|phone',
                'whatsapp_country' => 'required_with:whatsapp|max:4',
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required|string',
                'dropdown_id' => 'required|exists:dropdowns,id',
                'notes' => 'nullable|string|max:255',
            ]);

            $consultation = ClientConsultation::where('date', $data['date'])->where('time', $data['time'])->first();
            if ($consultation){
                return back()->withErrors([
                    'date' => __('errors.THIS_DATE_ALREADY_RESERVED')
                ])->withInput($data);
            }

            $data['whatsapp'] = ltrim($data['whatsapp'], '0');
            $phone = new \Propaganistas\LaravelPhone\PhoneNumber($data['whatsapp'], $data['whatsapp_country']);
            unset($data['whatsapp_country']);
            $data['whatsapp'] = $phone->formatInternational();
            $client_consultation = ClientConsultation::create($data);
            return redirect()->route('payment.process', ['model' => $service, 'type' => 'services', 'reference_id' => $client_consultation->id]);
        }

        return $this->view('services.' . $service->view_type, [
            'service' => $service,
            'slider' => $slider,
            'has_button' => $has_button,
            'form_choices' => $form_choices,
        ]);
    }

    public function cashback($locale){
        $promo_code_section = Dropdown::whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('trade-with-us-code-section')
            ->first()
            ?->blocks()
            ?->first();
        $promo_code = app(Site::class)->promo_code;

        $cashback_percentage_section = Dropdown::whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('trade-with-us-percentage-section')
            ->first()
            ?->blocks()
            ?->first();

        $account_type_1_cashback_percentage = Dropdown::whereCategory(Dropdown::CASHBACK_CATEGORY)->where('account_type', Dropdown::ACCOUNT_TYPE_1)->limit(7)->get();
        $account_type_2_cashback_percentage = Dropdown::whereCategory(Dropdown::CASHBACK_CATEGORY)->where('account_type', Dropdown::ACCOUNT_TYPE_2)->limit(7)->get();

        $cashback_activate_section = Dropdown::whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('trade-with-us-activate-code-section')
            ->first()
            ?->blocks()
            ?->first();

        return $this->view('services.cashback', [
            'promo_code_section' => $promo_code_section,
            'promo_code' => $promo_code,

            'cashback_percentage_section' => $cashback_percentage_section,
            'account_type_1_cashback_percentage' => $account_type_1_cashback_percentage,
            'account_type_2_cashback_percentage' => $account_type_2_cashback_percentage,

            'cashback_activate_section' => $cashback_activate_section,
        ]);
    }
}
