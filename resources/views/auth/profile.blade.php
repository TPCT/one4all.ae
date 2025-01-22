@extends('layouts.main')

@section('title', __("site.Profile"))

@section('id', 'profile')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/home.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/authentication.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/personal-consultation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/profile.css')}}">
@endpush

@section('content')
    <x-layout.header-image :title="__('site.Profile')" :breadcrumbs="[
                __('site.HOME') => route('site.index'),
                __('site.Profile') => ''
    ]"/>
    <section class="auth personal-consultation position-relative py-5">
        <div class="floating-up position-absolute">
            <img src="{{asset('/assets/imgs/home/bg-coin.png')}}" alt="" />
        </div>
        <div class="floating-down position-absolute">
            <img src="{{asset('/assets/imgs/home/bg-coin.png')}}" alt="" />
        </div>
        <div class="container">
            <div class="d-flex flex-column align-items-center">
                <div class="col-md-6">
                    @if ($package)
                            <div class="badge bg-success p-3 d-flex flex-column align-items-start">
                                <span class="mb-2">@lang('site.CLIENT_PACKAGE_SUBSCRIPTION') : {{$package->title}}</span>
                                <span>@lang('site.EXPIRATION_DATE'): {{\Illuminate\Support\Carbon::parse($package->pivot->expires_at)->toDateString()}}</span>
                            </div>
                    @endif

                    @if ($services->count())
                            <table class="table mt-2 shadow-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">@lang('site.SERVICE_NAME')</th>
                                        <th scope="col">@lang('site.EXPIRATION_DATE')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services as $index => $service)
                                        <tr>
                                            <th scope="row">{{$index + 1}}</th>
                                            <td>{{$service->title}}</td>
                                            <td>{{\Illuminate\Support\Carbon::parse($service->pivot->expires_at)->toDateString()}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    @endif
                </div>
            </div>
            <form method="post" action="{{route('auth.logout')}}" id="logout">
                @csrf
            </form>
            <form method="post">
                @csrf
                <div class="d-flex justify-content-center">
                    @if($success_message = session('success'))
                        <div class="my-3 alert alert-success">
                            <span class="">{{$success_message}}</span>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label class="mb-2">@lang('site.FIRST_NAME')</label>
                            <input
                                    value="{{old('first_name', $client->first_name)}}"
                                    name="first_name"
                                    type="text"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="@lang('site.FIRST_NAME_PLACEHOLDER')"
                            />
                        </div>
                        @error('first_name')
                        <span class="text-danger error">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label class="mb-2">@lang('site.LAST_NAME')</label>
                            <input
                                    value="{{old('last_name', $client->last_name)}}"
                                    name="last_name"
                                    type="text"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="@lang('site.LAST_NAME_PLACEHOLDER')"
                            />
                        </div>
                        @error('last_name')
                        <span class="text-danger error">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12 mb-3"  style="pointer-events: none">
                        <div class="form-group d-flex flex-column">
                            <label class="mb-2">@lang('site.PHONE')</label>
                            <input
                                    value="{{old('phone', $client->phone)}}"
                                    name="phone"
                                    id="phone"
                                    type="tel"
                                    class="form-control"
                                    aria-describedby="emailHelp"
                                    placeholder="@lang('site.PHONE_PLACEHOLDER')"
                            />
                        </div>
                        @error('phone')
                        <span class="text-danger error">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label class="mb-2">@lang('site.EMAIL_ADDRESS')</label>
                            <input
                                    value="{{old('email', $client->email)}}"
                                    name="email"
                                    type="email"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="@lang('site.EMAIL_ADDRESS_PLACEHOLDER')"
                            />
                        </div>
                        @error('email')
                        <span class="text-danger error">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label class="mb-2">@lang('site.PASSWORD')</label>
                            <input
                                    name="password"
                                    type="password"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="@lang('site.PASSWORD_PLACEHOLDER')"
                            />
                        </div>
                        @error('password')
                            <span class="text-danger error">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-around">
                    <button type="submit" class="main-btn w-100 my-3 mx-2">
                        <span> @lang('site.UPDATE_PROFILE') </span>
                    </button>
                    <button type="submit" class="main-btn bg-danger w-100 my-3 mx-2" form="logout">
                        <span> @lang('site.LOGOUT') </span>
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        const input = document.querySelector("#phone");
        const phone = window.intlTelInput(input, {
            initialCountry: "{{$client->country}}",
            loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/utils.js"),
        });
    </script>
@endpush