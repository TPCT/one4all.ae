@extends('layouts.main')

@section('title', __('site.ABOUT_US'))

@section('id', 'AboutUs')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/home.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/Recommendations.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/AboutUs.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/authentication.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/personal-consultation.css')}}">
@endpush

@section('content')
    <section class="recommendations-1st-section position-relative container">
        <div class="container">
            <div
                    class="d-flex flex-column justify-content-center h-100 gap-1 wow fadeInRight"
                    data-wow-delay="1s"
            >
                <h2>{{$about_us_section->title}}</h2>
                {!! $about_us_section->content !!}
                <a href="{{route('site.index') . "#services-section"}}">
                    @lang('site.OUR_SERVICES')
                    <picture>
                        <img src="{{asset('/assets/icons/weui_arrow-filled.svg')}}" alt="" />
                    </picture>
                </a>
            </div>
            <div class="row wow fadeInLeft" data-wow-delay=".5s">
                <picture>
                    <x-curator-glider
                        :media="$about_us_section->image_id"
                    />
                </picture>
            </div>
        </div>
    </section>

    <div class="about-us-video wow fadeInUp">
        <div class="container">
            <iframe
                    width="100%"
                    height="auto"
                    src="{{$about_us_section->youtube_video_id}}"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen
            ></iframe>
        </div>
    </div>
@endsection

@push('script')
@endpush