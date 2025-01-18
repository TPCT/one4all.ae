@extends('layouts.main')

@section('title', __("site.TRADING_COMPANIES"))

@section('id', 'tradingCompanies')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/TradingCompanies.css')}}">
@endpush

@section('content')
    <section class="tradingCompanies-1st-section">
        <div class="container wow fadeInUp">
            <h2>@lang('site.TRADING_COMPANIES_TITLE')</h2>
            <p>@lang('site.TRADING_COMPANIES_DESCRIPTION')</p>
        </div>
    </section>
    <section
            class="tradingCompanies-2nd-section wow fadeInUp"
            data-wow-delay="0.5s"
    >
        <div class="container">
            @foreach($companies as $company)
                <div class="company-card">
                    <picture class="company-card-main-pic">
                        <x-curator-glider
                                :media="$company->image_id"
                        />
                    </picture>
                    <div class="company-card-content">
                        <div>
                            <h3>{{$company->title}}</h3>
                            {!! $company->description !!}
                        </div>
                        <a href="{{$company->url}}">
                            @lang('site.SHOW_COMPANY')
                            <picture>
                                <img src="{{asset('/assets/icons/weui_arrow-filled.svg')}}" alt="" />
                            </picture>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('script')
@endpush