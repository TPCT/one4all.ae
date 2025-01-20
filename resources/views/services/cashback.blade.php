@extends('layouts.main')

@section('title', __("site.TRADE_WITH_US_HEADER_TITLE"))

@section('id', 'tradeWithUs')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/tradeWithUs.css')}}">
@endpush

@section('content')
    <x-layout.header-image :title="__('site.TRADE_WITH_US_HEADER_TITLE')" :breadcrumbs="[
                __('site.HOME') => route('site.index'),
                __('site.TRADE_WITH_US') => route('services.cashback')
    ]"/>

    @if ($promo_code_section)
        <section class="tradeWithUs-1st-section wow fadeInUp">
            <div class="container">
                <picture class="floating-coin-up">
                    <img
                            src="{{asset('/assets/imgs/tradeWithUs/cash in hand.png')}}"
                            alt=""
                            srcset=""
                    />
                </picture>
                <picture class="floating-coin-down">
                    <img
                            src="{{asset('/assets/imgs/tradeWithUs/lettering cashback orange text.png')}}"
                            alt=""
                            srcset=""
                    />
                </picture>
                <h2>{{$promo_code_section->title}}</h2>
                {!! $promo_code_section->description !!}
                <div class="copy-code-box">
                    <button id="copyButton">
                        <svg
                                width="34"
                                height="42"
                                viewBox="0 0 34 42"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                    d="M0.333008 0.166656H23.2497V4.33332H4.49967V31.4167H0.333008V0.166656ZM8.66634 8.49999H33.6663V41.8333H8.66634V8.49999ZM12.833 12.6667V37.6667H29.4997V12.6667H12.833Z"
                                    fill="black"
                            />
                        </svg>
                    </button>
                    <h2 id="codeToCopy">{{$promo_code}}</h2>
                </div>
            </div>
        </section>
    @endif

    @if ($cashback_percentage_section)
        <section class="tradeWithUs-2nd-section wow fadeInUp" data-wow-delay="1s">
            <div class="container">
                <h2>{{$cashback_percentage_section->title}}</h2>
                {!! $cashback_percentage_section->description !!}
                <div class="trade-accounts">
                    <div>
                        <h4>@lang("site." . \App\Models\Dropdown\Dropdown::ACCOUNT_TYPE_1)</h4>
                        <div class="standerd-account">
                            @foreach($account_type_1_cashback_percentage as $percentage)
                                <div>
                                    <p>{{$percentage->title}}</p>
                                    <svg
                                            width="28"
                                            height="35"
                                            viewBox="0 0 28 35"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M6.07966 11.1776C2.97636 13.5582 0.975586 17.3044 0.975586 21.5179C0.975586 28.7111 6.80681 34.5423 14 34.5423C21.1932 34.5423 27.0244 28.7111 27.0244 21.5179C27.0244 17.3054 25.0246 13.5599 21.9225 11.1792L14.823 0.924453C14.45 0.385453 13.552 0.385453 13.178 0.924453L6.07966 11.1776Z"
                                                fill="#E0FAF2"
                                        />
                                    </svg>
                                    <div class="price-cash">{{$percentage->lout_amount}} @lang('site.LOUT_CURRENCY')</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4>@lang("site." . \App\Models\Dropdown\Dropdown::ACCOUNT_TYPE_2)</h4>
                        <div class="ultralan-account">
                            @foreach($account_type_2_cashback_percentage as $percentage)
                                <div>
                                    <p>{{$percentage->title}}</p>
                                    <svg
                                            width="28"
                                            height="35"
                                            viewBox="0 0 28 35"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M6.07966 11.1776C2.97636 13.5582 0.975586 17.3044 0.975586 21.5179C0.975586 28.7111 6.80681 34.5423 14 34.5423C21.1932 34.5423 27.0244 28.7111 27.0244 21.5179C27.0244 17.3054 25.0246 13.5599 21.9225 11.1792L14.823 0.924453C14.45 0.385453 13.552 0.385453 13.178 0.924453L6.07966 11.1776Z"
                                                fill="#FFF9D7"
                                        />
                                    </svg>

                                    <div class="price-cash">{{$percentage->lout_amount}} @lang('site.LOUT_CURRENCY')</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


    @if ($cashback_activate_section)
        <section class="tradeWithUs-3rd-section wow fadeInUp" data-wow-delay="1s">
            <div class="container">
                <h2>{{$cashback_activate_section->title}}</h2>
                {!! $cashback_activate_section->description !!}
            </div>
        </section>
    @endif
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const copyButton = document.getElementById("copyButton");
            const codeToCopy = document.getElementById("codeToCopy");

            copyButton.addEventListener("click", function () {
                const textToCopy = codeToCopy.innerText;
                const tempInput = document.createElement("input");
                tempInput.value = textToCopy;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                alert("Code copied to clipboard: " + textToCopy);
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const popup = document.querySelector(".popup-section");
            const closePopup = document.querySelector(".popup-close-btn");
            const body = document.body;

            // Function to open the popup
            function openPopup() {
                popup.style.display = "flex";
                body.classList.add("no-scroll"); // Add no-scroll class to body
            }

            // Function to close the popup
            function closePopupFunction() {
                popup.style.display = "none";
                body.classList.remove("no-scroll"); // Remove no-scroll class from body
            }

            // Event listener for the close button
            closePopup.addEventListener("click", closePopupFunction);

            // Open the popup immediately
            openPopup();
        });
    </script>
@endpush