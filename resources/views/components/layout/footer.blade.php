@php use Illuminate\Support\Carbon; @endphp
        <!-- <footer class="main-footer-container">
    <div class="container footer-section">
        <div class="footer-item">
            <div class="footer-item-header">
                <a href="{{route('site.index')}}">
                    <x-curator-glider :media="$logo" class="mw-100 mb-5" />
                </a>
            </div>
            <div>
                {!! $footer_description !!}
</div>
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

<div class="footer-copyright-container">
    <div class="footer-copyright-container-centered">
        <p class="d-flex flex-column align-items-center">@lang('site.copyright', ['year' => Carbon::now()->year, 'url' => '<a href="https://shiftcodes.net">ShiftCodes</a>'])</p>
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
</footer> -->

<footer class="main-footer-container">
    <div class="container footer-section">
        <div class="footer-item">
            <div class="footer-item-header">
                <a href="{{route('site.index')}}">
                    <x-curator-glider :media="$logo" class="mw-100 mb-5"/>
                </a>
            </div>
            <div>
                {!! $footer_description !!}
            </div>

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
                            <form class="d-flex justify-content-between gap-2" id="newsletter-form"
                                  action="{{route('newsletter.subscribe')}}">
                                <div class="d-flex flex-column w-100" id="newsletter-email">
                                    <input type="email" placeholder="@lang('site.NEWSLETTER_EMAIL_PLACEHOLDER')"
                                           required/>
                                    <span class="d-none text-danger" id="newsletter-email-error"></span>
                                </div>
                                <button>@lang('site.NEWSLETTER_BUTTON_TEXT')</button>
                            </form>
                        </div>
                    </div>
                </section>
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
        <div class="footer-copyright-container-centered">
          <p>@lang('site.PAYMENT_METHOD')</p>
          <div class="social-media-icons">
            <a href="#">
              <i class="fa-brands fa-paypal"></i>
            </a>
            <a href="#">
              <i class="fa-brands fa-bitcoin"></i>
            </a>

          </div>
        </div>
        <div class="footer-copyright-container-centered">
            <p class="d-flex flex-column align-items-center">@lang('site.copyright', ['year' => Carbon::now()->year, 'url' => '<a href="https://shiftcodes.net">ShiftCodes</a>'])</p>
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