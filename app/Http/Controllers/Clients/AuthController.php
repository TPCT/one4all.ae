<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\InfoBip;
use App\Helpers\Responses;
use App\Helpers\SendOTP;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Settings\Site;
use Illuminate\Support\Facades\Validator;
use libphonenumber\PhoneNumber;
use Propaganistas\LaravelPhone\Rules\Phone;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

}
