@extends('layouts.main')

@section('title', '')

@section('id', 'Home')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/home.css')}}">
@endpush

@section('content')
    @if ($hero_slider)
        <section class="hero-section">
            <div class="container">
                <picture class="floating-coin-up">
                    <img src="{{asset('/assets/imgs/home/bg-coin.png')}}" alt="" srcset="" />
                </picture>
                <div class="hero-section-slider">
                    @foreach($hero_slider->slides as $slide)
                        <div class="hero-section-slide">
                            <div class="hero-section-slide-content">
                                <h1>{{$slide->title}}</h1>
                                <div class="hero-section-blue-title">
                                    <h1>{{$slide->second_title}}</h1>
                                </div>
                                <div>
                                    {!! $slide->description !!}
                                </div>
                                <a href="{{$slide->slide_url}}">
                                    @lang('site.HERO_SECTION_BUTTON_TITLE')
                                    <picture>
                                        <img src="{{asset('/assets/icons/weui_arrow-filled.svg')}}" alt="" />
                                    </picture>
                                </a>
                            </div>
                            <div class="position-relative img-hero-section">
                                <picture class="hero-main-slide-img">
                                    <x-curator-glider
                                        :media="$slide->image_id"
                                    />
                                </picture>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="hero-arrows-dots-container">
            <span class="hero-btn-main hero-arrows-prev slick-arrow">
              <i class="fa-solid fa-arrow-left"></i>
            </span>
                    <div class="hero-dots-container"></div>
                    <span class="hero-btn-main hero-arrows-next slick-arrow">
              <i class="fa-solid fa-arrow-right"></i>
            </span>
                </div>
            </div>
        </section>
    @endif
    @if ($about_us_section)
        <section class="home-2nd-section overflow-hidden">
            <div class="container">
                <div
                        class="home-2nd-section-content wow fadeInRight"
                        data-wow-duration="2s"
                >
                    <div class="Home-section-heading">
                        <h2>{{$about_us_section->title}}</h2>
                    </div>
                    {!! $about_us_section->description !!}
                    @foreach ($about_us_section->buttons as $button)
                        <a href="{{$button['url'][$language]}}">
                            {{$button['text'][$language]}}
                            <picture>
                                <img src="{{asset('/assets/icons/weui_arrow-filled.svg')}}" alt="" />
                            </picture>
                        </a>
                    @endforeach
                </div>

                <iframe
                        width="100%"
                        height="315"
                        src="{{$about_us_section->youtube_video_id}}"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen
                ></iframe>
            </div>
        </section>
    @endif
    @if ($services->count())
        <section class="home-3rd-section overflow-hidden">
            <div class="container home-3rd-main-container">
                <picture class="floating-coin-up">
                    <img src="{{asset('/assets/imgs/home/bg-coin.png')}}" alt="" srcset="" />
                </picture>
                <picture class="floating-coin-down">
                    <img src="{{asset('/assets/imgs/home/bg-coin.png')}}" alt="" srcset="" />
                </picture>
                <div class="Home-section-heading align-items-center wow fadeInUp">
                    <h2>@lang('site.SERVICES_SECTION_TITLE')</h2>
                    <p>@lang('site.SERVICES_SECTION_DESCRIPTION')</p>
                </div>
                <div
                        class="home-3rd-section-slider wow fadeInUp"
                        data-wow-delay=".5s"
                >
                    @foreach($services as $service)
                        <div class="home-3rd-section-slide">
                            <picture>
                                <x-curator-glider
                                    :media="$service->image_id"
                                />
                            </picture>
                            <div class="home-3rd-section-slide-content">
                                <div>
                                    <h3>{{$service->title}}</h3>
                                    {!! $service->description !!}
                                </div>
                                <a href="{{route('services.show', ['service' => $service])}}">
                                    @lang('site.SHOW_SERVICE')
                                    <picture>
                                        <img src="{{asset('/assets/icons/weui_arrow-filled.svg')}}" alt="" />
                                    </picture>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $(".hero-section-slider").slick({
                autoplay: true,
                autoplaySpeed: 2000,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                arrows: true,
                rtl: {{$rtl}},
                prevArrow: $(".hero-arrows-prev"),
                nextArrow: $(".hero-arrows-next"),
                appendDots: $(".hero-dots-container"),
                customPaging: function (slider, i) {
                    return '<span class="custom-dot"></span>';
                },
            });
        });

        $(document).ready(function () {
            $(".home-3rd-section-slider").slick({
                infinite: true,
                dots: false,
                arrows: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                centerMode: false,
                rtl: {{$rtl}},
                responsive: [
                    {
                        breakpoint: 991.88888,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 767.8888888,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        });
        $(document).ready(function () {
            $(".clints-reviews-slider").slick({
                infinite: true,
                dots: false,
                rtl: {{$rtl}},
                slidesToShow: 2.5,
                slidesToScroll: 1,
                arrows: true,
                prevArrow: $(".clints-reviews-arrows-prev"),
                nextArrow: $(".clints-reviews-arrows-next"),
                responsive: [
                    {
                        breakpoint: 991.88888,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 767.8888888,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        });
    </script>
@endpush