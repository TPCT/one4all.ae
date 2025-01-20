<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\InfoBip;
use App\Helpers\Responses;
use App\Helpers\SendOTP;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Dropdown\Dropdown;
use App\Settings\Site;
use Illuminate\Support\Facades\Validator;
use libphonenumber\PhoneNumber;
use Propaganistas\LaravelPhone\Rules\Phone;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(){
        if (request()->isMethod('POST')){}

        $login_page_section = Dropdown::active()->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('login-page-section')
            ->first()
            ?->blocks()
            ->first();
        return $this->view('auth.login', [
            'login_page_section' => $login_page_section
        ]);
    }

    public function register(\Request $request){
        if (request()->isMethod('POST')){
            $data = request()->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'phone'],
                'phone_country' => ['required_with:phone', 'max:4'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:clients,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $data['active'] = 1;
            $data['password'] = \Hash::make($data['password']);

            $phone = new \Propaganistas\LaravelPhone\PhoneNumber($data['phone'], $data['phone_country']);
            unset($data['phone_country']);
            $data['country_code'] = $phone->formatInternational();
            $data['country_code'] = \Str::before($data['country_code'], ' ');
            Client::create($data);
            return redirect()->to(route('auth.login'))->with('success', __("site.ACCOUNT_CREATED_SUCCESSFULLY"));
        }

        $register_page_section = Dropdown::active()->whereCategory(Dropdown::BLOCK_CATEGORY)
            ->whereSlug('register-page-section')
            ->first()
            ?->blocks()
            ->first();
        return $this->view('auth.register', [
            'register_page_section' => $register_page_section
        ]);
    }
}
