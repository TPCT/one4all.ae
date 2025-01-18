<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Dropdown\Dropdown;
use App\Models\Service\Service;

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
}
