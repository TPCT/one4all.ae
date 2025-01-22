<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\InfoBip;
use App\Helpers\Responses;
use App\Helpers\SendOTP;
use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordEmail;
use App\Models\Client;
use App\Models\Dropdown\Dropdown;
use App\Models\PasswordToken;
use App\Settings\Site;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use libphonenumber\PhoneNumber;
use Propaganistas\LaravelPhone\Rules\Phone;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(){
        if (request()->isMethod('POST')){
            $data = request()->only('email', 'password', 'remember');
            if (!isset($data['email'], $data['password']))
                return redirect()->route('auth.login')->withErrors([
                    'email' => __("errors.INVALID_EMAIL_OR_PASSWORD")
                ]);

            if (\Auth::guard('clients')->attempt(['email' => $data['email'], 'password' => $data['password']])){
                return redirect()->route('site.index');
            }

            return redirect()->route('auth.login')->withErrors([
                'email' => __("errors.INVALID_EMAIL_OR_PASSWORD")
            ]);
        }

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
            $data['phone'] = ltrim($data['phone'], '0');
            $data['country'] = $data['phone_country'];

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

    public function profile(){
        if (request()->isMethod('POST')){
            $data = request()->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:clients,email,' . auth()->user()->id],
                'password' => ['sometimes'],
            ]);

            if ($data['password'])
                $data['password'] = \Hash::make($data['password']);
            else
                unset($data['password']);
            auth()->user()->update($data);
            return redirect()->to(route('profile.edit'))->with('success', __("site.ACCOUNT_UPDATED_SUCCESSFULLY"));
        }

        $client = \Auth::guard('clients')->user();

        $services = $client->services()->where(function ($query){
            $query->where('client_services.expires_at', '>', Carbon::today()->toDateString());
        })->withPivot('expires_at')->get();


        $package = $client->packages()->latest()->withPivot('expires_at')->where(function ($query) {
            $query->where('client_packages.expires_at', '>', Carbon::today()->toDateString());
        })->first();

        return $this->view('auth.profile', [
            'client' => $client,
            'package' => $package,
            'services' => $services
        ]);
    }

    public function logout(){
        \Auth::guard('clients')->logout();
        session()->flush();
        session()->invalidate();
        session()->regenerate();
        return redirect()->route('auth.login');
    }

    public function forgotPassword(){
        if (request()->isMethod('POST')){
            $data = request()->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);

            if ($data['email']){
                $client = Client::where('email', $data['email'])->first();
                $password = \Str::random(8);
                $client->update(['password' => \Hash::make($password)]);
                \Mail::to($client->email)->send(new ResetPasswordEmail([
                    'name' => $client->first_name . ' ' . $client->last_name,
                    'password' => $password,
                ]));
            }
            return redirect()->route('auth.login')->with('success', __("site.ACCOUNT_RESET_PASSWORD_DONE_SUCCESSFULLY"));
        }

        return $this->view('auth.reset-password');
    }
}
