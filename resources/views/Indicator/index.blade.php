@extends('layouts.main')

@section('title', __('site.Indicator'))

@section('id', 'Indicator')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/home.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/AboutUs.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/indicator.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/home.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/authentication.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/Recommendations.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/personal-consultation.css')}}"/>
@endpush

@section('content')
    <div class="indicator">
        <div class="container">
            <div class="row mt-4">
                <div class="col-lg-2 d-flex align-items-center">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">@lang('site.SYMBOL')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($currencies as $loop_currency)
                            <tr>
                                <th scope="row">
                                    <a href="?stamp={{$stamp}}&currency={{$loop_currency->code}}" class="text-decoration-none text-dark">
                                        <picture>
                                            <x-curator-glider
                                                    :media="$loop_currency->image_id"
                                                    class="mw-100"
                                            />
                                        </picture>
                                        {{$loop_currency->title}}
                                    </a>
                                </th>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-10 indicator-chart d-flex align-items-center justify-content-center">
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
                                "locale": "{{$language}}",
                                "colorTheme": localStorage.getItem("mode") == "light-mode" ? "light" : "dark"
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