@php use Illuminate\Support\Carbon; @endphp
<footer class="main-footer-container">
    <div class="container footer-section">
        <div class="footer-item">
            <div class="footer-item-header">
                <a href="{{route('site.index')}}">
                    <x-curator-glider :media="$logo" class="mw-100 "/>
                </a>
            </div>

            @if ($newsletter_section)
                <div class="home-6th-section p-0" id="newsletter-container">
                    <div class="d-flex align-items-start flex-column h-100 py-4">
                        <div>
                            <h5>{{$newsletter_section->title}}</h5>
                            <p>
                                {{$newsletter_section->second_title}}
                            </p>
                        </div>
                        <form id="newsletter-form" action="{{route('newsletter.subscribe')}}"></form>
                        <div class="d-flex justify-content-between gap-2">
                            <div class="d-flex flex-column w-100" id="newsletter-email">
                                <input form="newsletter-form" name="email" id="newsletter-email-input" type="email"
                                       placeholder="@lang('site.NEWSLETTER_EMAIL_PLACEHOLDER')" required/>
                                <span class="d-none text-danger" id="newsletter-email-error"></span>
                            </div>
                            <button class="border-0"
                                    form="newsletter-form">@lang('site.NEWSLETTER_BUTTON_TEXT')</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @foreach($menu->links as $index => $child)
            @continue(!$child->status || !$child->has_children())
            <div class="footer-item">
                <div class="footer-item-header">
                    <h5>{{$child->title}}</h5>
                    <button
                            class="toggleButton mobile-responsive"
                            data-target="footer-link-{{$index}}"
                    >
                        <i class="fa-solid fa-plus"></i>
                        <i class="fa-solid fa-minus" style="display: none"></i>
                    </button>
                </div>
                <ul id="footer-link-{{$index}}">
                    @foreach($child->children as $grandson)
                        <li>
                            <a href="{{$grandson->link}}">{{$grandson->title}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
    <div class="footer-copyright-container">
        @if ($payment_gateways?->count())
            <div class="footer-copyright-container-centered">
                <div class="social-media-icons">
                    <a>
                        <picture>
                            <img src="{{asset('/assets/imgs/paypal app.png')}}" alt="" class="mw-100 w-100"/>
                        </picture>
                    </a>
                    @foreach($payment_gateways as $payment_gateway)
                        <a>
                            <picture>
                                <x-curator-glider
                                        :media="$payment_gateway->image_id"
                                        class="mw-100 w-100"
                                />
                            </picture>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="footer-copyright-container-centered">
            <p class="d-flex gap-2 align-items-center">@lang('site.copyright', ['year' => Carbon::now()->year, 'url' => '<a href="https://shiftcodes.net" class="web-link">ShiftCodes</a>'])</p>
            <div class="social-media-icons">
                @if ($twitter)
                    <a href="{{$twitter}}" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                @endif
                @if ($linkedin)
                    <a href="{{$linkedin}}" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                @endif
                @if ($instagram)
                    <a href="{{$instagram}}" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                @endif
                @if ($youtube)
                    <a href="{{$youtube}}" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                @endif
                @if ($facebook)
                    <a href="{{$facebook}}" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</footer>

@push('script')
    <script>
        $(function () {
            $("#newsletter-form").on('submit', function (e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: $(this).attr('action') + "?email=" + $("#newsletter-email-input").val(),
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        if (res.success) {
                            $("#newsletter-container").remove();
                        } else {
                            $("#newsletter-email-error").text(res.message).removeClass('d-none').addClass('d-flex')
                        }
                    },
                    error: function (res) {
                    }
                });
            });
        });
    </script>
@endpush