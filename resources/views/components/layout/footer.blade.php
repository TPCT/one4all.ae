<footer class="main-footer-container">
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
            <div class="container d-flex">
                <div class="d-flex flex-column" id="newsletter-container">
                    <div>
                        <h2>اشترك في أخبارنا</h2>
                        <p>
                            هل سئمت من فقدان تحديثاتنا؟ اشترك في أخبارنا الآن وابق على اطلاع!
                        </p>
                    </div>
                    <form class="d-flex " id="newsletter-form" action="https://ofa01sc2025.shiftcodes.net/ar/newsletter/subscribe">
                        <div class="d-flex flex-column w-50" id="newsletter-email">
                            <input type="email" placeholder="البريد الالكتروني" required="">
                            <span class="d-none text-danger" id="newsletter-email-error"></span>
                        </div>
                        <button>تاكيد</button>
                    </form>
                </div>
                <picture>
                    <img src="/storage/media/ebb2b7dd-e86b-48dc-8b4e-bdd3dda32d6c.png?s=35f949213d42112fdffd61b16401a991" alt="" quality="5" format="webp" force="force" loading="lazy">
                    </picture>
            </div>
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
            <p class="d-flex flex-column align-items-center">@lang('site.copyright', ['year' => \Illuminate\Support\Carbon::now()->year, 'url' => '<a href="https://shiftcodes.net">ShiftCodes</a>'])</p>
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