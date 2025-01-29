@extends('layouts.main')

@section('title', __('site.Payment Processing'))

@section('id', 'Payment')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/home.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/AboutUs.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/Recommendations')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/authentication.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/payment.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/personal-consultation.css')}}" />
@endpush

@section('content')
    <section class="recommendations-1st-section position-relative mt-5">
        <div class="container d-flex flex-column align-items-start gap-3 p-2">
            <div class="head-payment">
                <h2>@lang('site.Pay Service Fees')</h2>
            </div>
            <div
                    class="title-payment d-flex align-items-center gap-2 w-100 bg-white"
            >
                <picture>
                    @if ($model->image_id)
                        <x-curator-glider
                            :media="$model->image_id"
                            width="50px"
                            height="50px"
                        />
                    @else
                        <img src="{{asset('/assets/imgs/payment.png')}}" alt="{{$model->title}}"/>
                    @endif
                </picture>
                <h4>{{$model->title}}</h4>
            </div>
            <div class="head-payment">
                <h2>@lang('site.Choose Payment Method')</h2>
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button
                            class="nav-link active"
                            id="home-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#home-tab-pane"
                            type="button"
                            role="tab"
                            aria-controls="home-tab-pane"
                            aria-selected="true"
                    >
                        <i class="fa-brands fa-paypal"></i>
                        @lang('site.PAYPAL')
                    </button>
                </li>

                @foreach($gateways as $gateway)
                    <li class="nav-item" role="presentation">
                        <button
                                class="nav-link"
                                id="profile-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#{{$gateway->slug}}-tab-pane"
                                type="button"
                                role="tab"
                                aria-controls="{{$gateway->slug}}-tab-pane"
                                aria-selected="false"
                        >
                            <x-curator-glider
                                :media="$gateway->image_id"
                                width="50px"
                                height="50px"
                            />
                            {{$gateway->title}}
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" id="myTabContent">
                <div
                        class="tab-pane fade show active"
                        id="home-tab-pane"
                        role="tabpanel"
                        aria-labelledby="home-tab"
                        tabindex="0"
                >
                    <div class="tab-content-pay-detail">
                        <picture>
                            <img src="{{asset('/assets/imgs/paypal app.png')}}" alt="" />
                        </picture>
                        <h3>@lang('site.PAY_USING_PAYPAL_TITLE')</h3>
                        <p>@lang('site.PAY_USING_PAYPAL_DESCRIPTION')</p>
                        <a href="{{$paypal_payment_link}}" class="text-decoration-none btn btn-primary bg-primary" role="button">
                            @lang('site.Pay now')
                            <picture>
                                <img src="{{asset('/assets/icons/weui_arrow-filled.svg')}}" alt="" />
                            </picture>
                        </a>
                    </div>
                </div>
                @foreach($gateways as $gateway)
                    <div
                            class="tab-pane fade"
                            id="{{$gateway->slug}}-tab-pane"
                            role="tabpanel"
                            aria-labelledby="profile-tab"
                            tabindex="0"
                    >
                        <div class="tab-content-pay-detail">
                            <picture>
                                <x-curator-glider
                                        :media="$gateway->image_id"
                                        width="50px"
                                        height="50px"
                                />
                            </picture>
                            {!! str_replace("[[price]]", $model->price, $gateway->content) !!}

                            @if ($whatsapp_link = app(\App\Settings\Site::class)->contact_us_whatsapp_number)
                                <a href="{{$whatsapp_link}}" class="wa-pay">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <p>@lang('site.Contact Us')</p>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('script')

@endpush