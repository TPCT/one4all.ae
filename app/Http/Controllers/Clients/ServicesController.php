<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Dropdown\Dropdown;
use App\Models\Service\Service;
use App\Settings\Site;

class ServicesController extends Controller
{
    public function show($locale, Service $service){
        $slider = $service->slider;
        $form_choices = Dropdown::active()->whereCategory(Dropdown::CONSULTATION_CATEGORY)->get();
        return $this->view('services.' . $service->view_type, [
            'service' => $service,
            'slider' => $slider,
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
