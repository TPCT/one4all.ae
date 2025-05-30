@extends('layouts.main')

@section('title', __('site.Indicator'))

@section('id', 'Indicator')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/home.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/AboutUs.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/indicator.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/cssauthentication.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/Recommendations.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/personal-consultation.css')}}"/>
@endpush

@section('content')
    <div class="indicator">
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-2 d-flex align-items-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">@lang('site.SYMBOL')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($currencies as $loop_currency)
                            <tr>
                                <td>
                                    <a href="?currency={{$loop_currency->code}}" class="text-decoration-none text-dark">
                                        <picture>
                                            <x-curator-glider
                                                    :media="$loop_currency->image_id"
                                                    class="mw-100"
                                            />
                                        </picture>
                                        {{$loop_currency->title}}
                                    </a>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-10 indicator-chart d-flex align-items-center justify-content-center">
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-technical-analysis.js" async>
                            {
                                "interval": "1D",
                                "width": "100%",
                                "isTransparent": true,
                                "height": "100%",
                                "symbol": "{{$currency->code}}",
                                "showIntervalTabs": true,
                                "displayMode": "single",
                                "locale": "{{app()->getLocale() == "ar" ? "ar_AE" : "en"}}",
                                "colorTheme": "{{session('mode', 'light')}}"
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush