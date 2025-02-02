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
        <section class="home-3rd-section overflow-hidden" id="services-section">
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

    @if ($packages->count())
        <section class="pricing py-5 overflow-hidden">
            <div class="container">
                <div class="Home-section-heading align-items-center wow fadeInUp">
                    <h2>@lang('site.PRICING_TITLE')</h2>
                    <p>@lang('site.PRICING_DESCRIPTION')</p>
                </div>
                <div class="row wow fadeInUp" data-wow-delay=".5s">
                    @foreach($packages as $index => $package)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div
                                    class="pricing-card border p-3 d-flex flex-column justify-content-between gap-5 rounded-4"
                            >
                                @if ($package->discount)
                                    <div class="pricing-offer">
                                        <h3>{{$package->discount}}</h3>
                                    </div>
                                @endif
                                <div class="pricing-card-content">
                                    <h1 class="pricing-number">{{$index + 1}}</h1>
                                    <h2>{{$package->title}}</h2>
                                    {!! $package->description !!}
                                </div>
                                <ul class="pricing-details">
                                    @foreach($package->items as $item)
                                        <li>{{$item->title}}</li>

                                    @endforeach
                                </ul>
                                @if ($has_button)
                                    <div
                                            class="package-price-container d-flex align-items-center justify-content-between"
                                    >
                                        <div class="package-price d-flex align-items-center gap-2">
                                            <h3>{{$package->price}}</h3>
                                            <p>@lang('site.PACKAGE_CURRENCY')</p>
                                        </div>
                                        <a href="{{route('payment.process', ['type' => 'packages', 'model' => $package->id])}}" class="main-btn"> @lang('site.SUBSCRIBE_NOW') </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($faqs_section)
        <section class="Home-4th-section overflow-hidden">
            <div
                    class="container Home-section-heading align-items-center wow fadeInUp"
            >
                <h2>{{$faqs_section->title}}</h2>
                <h4>{{$faqs_section->second_title}}</h4>
            </div>
            <div
                    class="container Home-4th-container wow fadeInUp"
                    data-wow-delay="0.5s"
            >
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    @foreach($faqs as $index => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-heading-{{$index}}">
                                <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse-{{$index}}"
                                        aria-expanded="false"
                                        aria-controls="flush-collapse-{{$index}}"
                                >
                                    {{$faq->title}}
                                </button>
                            </h2>
                            <div
                                    id="flush-collapse-{{$index}}"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="flush-heading-{{$index}}"
                                    data-bs-parent="#accordionFlushExample"
                            >
                                <div class="accordion-body">
                                    {!! $faq->description !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div>
                    <picture class="faqs-img-box">
                        <x-curator-glider
                            :media="$faqs_section->image_id"
                        />
                        <svg
                                width="486"
                                height="444"
                                viewBox="0 0 486 444"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                    d="M0 24.3327C0 3.5374 24.645 -7.41679 40.0814 6.51729L477.676 401.522C493.991 416.248 483.573 443.337 461.595 443.337H24C10.7452 443.337 0 432.592 0 419.337V24.3327Z"
                            />
                        </svg>
                    </picture>
                </div>
            </div>
        </section>
    @endif

    @if ($testimonials_section)
        <section class="home-5th-section overflow-hidden">
            <div class="container fifth-section-heading">
                <div class="Home-section-heading wow fadeInUp">
                    <h2>{{$testimonials_section->title}}</h2>
                    <h4>{{$testimonials_section->second_title}}</h4>
                </div>
                <div class="clints-reviews-arrows-container wow fadeInUp">
            <span
                    class="clints-reviews-btn-main clints-reviews-arrows-prev slick-arrow"
            >
              <i class="fa-solid fa-chevron-left"></i>
            </span>
                    <span
                            class="clints-reviews-btn-main clints-reviews-arrows-next slick-arrow"
                    >
              <i class="fa-solid fa-chevron-right"></i>
            </span>
                </div>
            </div>
            <div class="clints-reviews-slider wow fadeInUp" data-wow-delay="0.5s">
                @foreach($testimonials as $testimonial)
                    <div class="clints-reviews-slide">
                        {!! $testimonial->description !!}
                        <div class="clints-reviews-slide-content">
                            <div>
                                <picture>
                                    <x-curator-glider
                                        :media="$testimonial->image_id"
                                    />
                                </picture>
                                <div class="clints-reviews-identity">
                                    <p>{{$testimonial->name}}</p>
                                    <p>{{$testimonial->position}}</p>
                                </div>
                            </div>
                            <svg
                                    width="42"
                                    height="32"
                                    viewBox="0 0 42 32"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                        d="M37.6183 27.416C41.3923 23.32 41.0123 18.06 41.0003 18V2C41.0003 1.46957 40.7896 0.960859 40.4145 0.585787C40.0395 0.210714 39.5308 0 39.0003 0H27.0003C24.7943 0 23.0003 1.794 23.0003 4V18C23.0003 18.5304 23.211 19.0391 23.5861 19.4142C23.9612 19.7893 24.4699 20 25.0003 20H31.1563C31.1141 20.9888 30.8186 21.9501 30.2983 22.792C29.2823 24.394 27.3683 25.488 24.6063 26.04L23.0003 26.36V32H25.0003C30.5663 32 34.8123 30.458 37.6183 27.416ZM15.6043 27.416C19.3803 23.32 18.9983 18.06 18.9863 18V2C18.9863 1.46957 18.7756 0.960859 18.4005 0.585787C18.0255 0.210714 17.5168 0 16.9863 0H4.98633C2.78033 0 0.986328 1.794 0.986328 4V18C0.986328 18.5304 1.19704 19.0391 1.57211 19.4142C1.94719 19.7893 2.4559 20 2.98633 20H9.14233C9.10007 20.9888 8.80464 21.9501 8.28433 22.792C7.26833 24.394 5.35433 25.488 2.59233 26.04L0.986328 26.36V32H2.98633C8.55233 32 12.7983 30.458 15.6043 27.416Z"
                                />
                            </svg>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if($newsletter_section)
        <section class="home-6th-section">
            <div class="container">
                <div class="d-flex justify-content-between flex-column h-100 py-4" id="newsletter-container">
                    <div>
                        <h2>{{$newsletter_section->title}}</h2>
                        <p>
                            {{$newsletter_section->second_title}}
                        </p>
                    </div>
                    <form class="d-flex justify-content-between gap-2" id="newsletter-form" action="{{route('newsletter.subscribe')}}">
                        <div class="d-flex flex-column w-100" id="newsletter-email">
                            <input type="email" placeholder="@lang('site.NEWSLETTER_EMAIL_PLACEHOLDER')" required/>
                            <span class="d-none text-danger" id="newsletter-email-error"></span>
                        </div>
                        <button>@lang('site.NEWSLETTER_BUTTON_TEXT')</button>
                    </form>
                </div>
                <picture>
                    <x-curator-glider
                        :media="$newsletter_section->image_id"
                    />
                </picture>
            </div>
        </section>
    @endif
@endsection

@push('script')
    <script>
        $(function (){
            $("#newsletter-form").on('submit', function (e){
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: $(this).attr('action') + "?email=" + $(this).find('input').val(),
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        if (res.success){
                            form.remove();
                            $("#newsletter-container").append(`
                                <div class="d-flex justify-content-center"><span class="text-success">` + res.message + `</span></div>
                            `);
                        }else{
                            $("#newsletter-email-error").text(res.message).removeClass('d-none').addClass('d-flex')
                        }
                    },
                    error: function (res){
                    }
                });
            });
        });
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