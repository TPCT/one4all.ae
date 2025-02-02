@extends('layouts.main')

@section('title', __("site.Register"))

@section('id', 'Register')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/home.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/authentication.css')}}">
@endpush

@section('content')
    <x-layout.header-image :title="__('site.Register')" :breadcrumbs="[
                __('site.HOME') => route('site.index'),
                __('site.Register') => ''
    ]"/>

    <section class="auth">
        <div class="container">
            <form method="post" action="{{route('auth.register')}}">
                @csrf
                @method('POST')
                <input type="hidden" name="phone_country" id="phone_country">
                <div class="head-form mb-5">
                    <h1>{{$register_page_section->title}}</h1>
                    {!! $register_page_section->description !!}
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label class="mb-2">@lang('site.FIRST_NAME')</label>
                            <input
                                    value="{{old('first_name')}}"
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
                                    value="{{old('last_name')}}"
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
                    <div class="col-lg-12 mb-3">
                        <div class="form-group d-flex flex-column">
                            <label class="mb-2">@lang('site.PHONE')</label>
                            <input
                                    value="{{old('phone')}}"
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
                                    value="{{old('email')}}"
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
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label class="mb-2">@lang('site.PASSWORD_CONFIRMATION')</label>
                            <input
                                    name="password_confirmation"
                                    type="password"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="@lang('site.PASSWORD_CONFIRMATION_PLACEHOLDER')"
                            />
                        </div>
                        @error('password_confirmation')
                            <span class="text-danger error">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="main-btn w-100 my-3">
                    <span> @lang('site.CREATE_ACCOUNT_BUTTON') </span>
                </button>
                <p class="text-center">
                    @lang('site.LOGIN_REGISTER_PAGE_DESCRIPTION')
                    <a href="{{route('auth.login')}}">@lang('site.Login')</a>
                </p>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        const input = document.querySelector("#phone");
        const phone = window.intlTelInput(input, {
            initialCountry: "EG",
            loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/utils.js"),
        });

        $("form").one('submit', function (e){
            e.preventDefault();
            $("#phone_country").val(phone.getSelectedCountryData().iso2)
            $(this).submit();
        })
    </script>
@endpush