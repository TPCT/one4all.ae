@extends('layouts.main')

@section('title', $service->title)

@section('id', 'PersonalConsultation')

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/home.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/authentication.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/Recommendations.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/personal-consultation.css')}}"/>
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
            </div>
            <picture class="recommendations-img-box wow fadeInLeft">
                <x-curator-glider
                        :media="$service->image_id"
                />
            </picture>
        </div>
    </section>
    <section class="auth personal-consultation position-relative">
        <div class="floating-up position-absolute">
            <img src="{{asset('/assets/imgs/home/bg-coin.png')}}" alt="" />
        </div>
        <div class="floating-down position-absolute">
            <img src="{{asset('/assets/imgs/home/bg-coin.png')}}" alt="" />
        </div>
        <div class="container">
            <form method="post">
                @csrf
                <input type="hidden" name="whatsapp_country" id="whatsapp_country">
                <div
                        class="head-form mb-5 d-flex flex-column align-items-center pt-5 wow fadeInUp"
                >
                    <h1>@lang('site.SERVICE_' . $service->id . "_FORM_TITLE")</h1>
                    <p>@lang('site.SERVICE_' . $service->id . "_FORM_DESCRIPTION")</p>
                </div>
                <div class="row wow fadeInUp" data-wow-delay="0.5s">
                    <div class="col-lg-12 mb-3">
                        <div class="form-group d-flex flex-column">
                            <label class="mb-2">@lang('site.CONSULTATION_WHATSAPP_NUMBER')</label>
                            <input
                                    type="tel"
                                    class="form-control"
                                    id="whatsapp"
                                    name="whatsapp"
                                    value="{{old('whatsapp')}}"
                                    aria-describedby="@lang('site.CONSULTATION_WHATSAPP_PLACEHOLDER')"
                                    placeholder="@lang('site.CONSULTATION_WHATSAPP_PLACEHOLDER')"
                            />
                        </div>
                        @error('whatsapp')
                            <span class="text-danger error">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label class="mb-2">@lang('site.CONSULTATION_DATE')</label>
                            <input
                                    type="date"
                                    class="form-control"
                                    id="date"
                                    name="date"
                                    value="{{old('date')}}"
                                    min="{{Carbon\Carbon::today()->format('Y-m-d')}}"
                                    aria-describedby="@lang('site.CONSULTATION_DATE_PLACEHOLDER')"
                                    placeholder="@lang('site.CONSULTATION_DATE_PLACEHOLDER')"
                            />
                        </div>
                        @error('date')
                            <span class="text-danger error">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label class="mb-2">@lang('site.CONSULTATION_TIME')</label>
                            <select class="form-select form-control w-100" name="time">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{$i}} PM" @selected(old('time') == $i)>@lang('site.CLOCK') {{$i}} @lang('site.PM')</option>
                                @endfor
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{$i}} AM" @selected(old('time') == $i)>@lang('site.CLOCK') {{$i}} @lang('site.AM')</option>
                                @endfor
                            </select>
                        </div>
                        @error('time')
                            <span class="text-danger error">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12 mb-3">
                        <label class="mb-2">@lang('site.CONSULTATION_TYPE')</label>
                        <div class="checks">
                            @foreach($form_choices as $choice)
                                <div class="form-check">
                                    <input
                                            class="form-check-input"
                                            type="radio"
                                            name="dropdown_id"
                                            value="{{$choice->id}}"
                                            id="consultation-type-{{$choice->id}}"
                                            @checked($choice->id == old('dropdown_id'))
                                    />
                                    <label class="form-check-label" for="consultation-type-{{$choice->id}}">
                                        {{$choice->title}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('dropdown_id')
                            <span class="text-danger error">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label class="mb-2" for="notes">@lang('site.CONSULTATION_NOTES')</label>
                            <textarea
                                    class="form-control"
                                    name="notes"
                                    id="notes"
                                    rows="7"
                                    placeholder="@lang('site.CONSULTATION_NOTES_PLACEHOLDER')"
                            >{{old('notes')}}</textarea>
                        </div>
                    </div>
                    @error('notes')
                        <span class="text-danger error">{{$message}}</span>
                    @enderror
                </div>
                <button type="submit" class="main-btn w-100 my-3">
                    <span> @lang('site.CONFIRM_ORDER') </span>
                </button>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        const input = document.querySelector("#whatsapp");
        const phone = window.intlTelInput(input, {
            initialCountry: "EG",
            loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/utils.js"),
        });

        $("form").one('submit', function (e){
            e.preventDefault();
            $("#whatsapp_country").val(phone.getSelectedCountryData().iso2)
            $(this).submit();
        })
    </script>
@endpush