@extends('layouts.main')

@section('title', $service->title)

@section('id', 'PersonalConsultation')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/Recommendations.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/personal-consultation.css')}}">
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
            <div class="video wow fadeInLeft">
                <iframe width="100%" height="450" src="{{$service->youtube_video_id}}"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </section>
    @if ($slider)
        <section class="recommendations-2nd-section">
            <h2>{{$slider->title}}</h2>
            {!! $slider->description !!}
            <div class="container position-relative">
                <div class="recommendations-slider">
                    @foreach($slider->slides as $slide)
                        <div>
                            <picture>
                                <x-curator-glider
                                        :media="$slide->image_id"
                                />
                            </picture>
                        </div>
                    @endforeach
                </div>
                <div class="recommendations-arrows-container">
                    <span class="recommendations-btn-main recommendations-arrows-prev slick-arrow">
                        <i class="fa-solid fa-chevron-left"></i>
                    </span>
                    <span class="recommendations-btn-main recommendations-arrows-next slick-arrow">
                      <i class="fa-solid fa-chevron-right"></i>
                    </span>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('script')
    <script>
        $(document).ready(function () {


            $(".recommendations-slider").slick({
                infinite: true,
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                rtl: {{$rtl}},
                arrows: true,
                prevArrow: $(".recommendations-arrows-prev"),
                nextArrow: $(".recommendations-arrows-next"),
            });
        });
    </script>
@endpush