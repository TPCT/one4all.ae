<section class="toolbar py-3">
    <div
            class="container d-flex align-items-center justify-content-between"
    >
        <div class="dark-light-btn d-flex align-items-center gap-2">
            <div class="main-btn d-flex align-items-center gap-2">
                <i class="fa-solid fa-sun"></i>
                <p class="m-0">@lang('site.BRIGHT_MODE')</p>
            </div>
            <div class="third-btn d-flex align-items-center gap-2">
                <i class="fa-solid fa-moon"></i>
                <p class="m-0">@lang('site.DARK_MODE')</p>
            </div>
        </div>
            <div class="lang-join-btn d-flex align-items-center gap-2">
                @if($telegram_link)
                    <a
                            href="{{$telegram_link}}"
                            class="d-flex align-items-center gap-2 sec-btn"
                    >
                        <i class="fa-brands fa-telegram"></i>
                        <p class="m-0">@lang('site.JOIN_TELEGRAM_GROUP')</p>
                    </a>
                @endif
                <x-layout.language-switcher></x-layout.language-switcher>
            </div>
    </div>
</section>