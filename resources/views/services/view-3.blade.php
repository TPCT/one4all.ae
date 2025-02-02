@extends('layouts.main')

@section('title', $service->title)

@section('id', 'PersonalConsultation')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/AboutUs.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/home.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/authentication.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/Recommendations.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/personal-consultation.css')}}"/>
@endpush

@section('content')
    <x-layout.header-image :model="$service" :breadcrumbs="[
                __('site.HOME') => route('site.index'),
                $service->title => route('services.show', ['service' => $service])
    ]"/>
    <section class="recommendations-1st-section position-relative">
        <div class="container">
            <div
                    class="d-flex flex-column justify-content-center h-100 gap-4 wow fadeInRight"
                    data-wow-delay="1s"
            >
                <h2>{{$service->title}}</h2>
                <div>
                    {!! $service->content !!}
                </div>
                <div class="price">
                    <span>@lang('site.SERVICE_' . $service->id . "_PRICE")</span>
                    <h2>{{$service->price}} @lang('site.SERVICE_' . $service->id . "_CURRENCY")</h2>
                </div>
                @if ($has_button)
                    <a href="{{route('payment.process', ['model' => $service, 'type' => 'services'])}}">
                        @lang('site.SUBSCRIBE_NOW')
                        <picture>
                            <img src="{{asset('/assets/icons/weui_arrow-filled.svg')}}" alt=""/>
                        </picture>
                    </a>
                @endif
            </div>
            <picture class="recommendations-img-box wow fadeInLeft">
                <x-curator-glider
                        :media="$service->image_id"
                />
            </picture>
        </div>
    </section>
    @if ($service->youtube_video_id)
        <div class="about-us-video wow fadeInUp">
            <div class="container">
                <iframe
                        width="100%"
                        height="auto"
                        src="{{$service->youtube_video_id}}"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen
                ></iframe>
            </div>
        </div>
    @endif
@endsection

@push('script')
@endpush