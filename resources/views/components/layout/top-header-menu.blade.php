<section class="toolbar py-3">
    <div
            class="container d-flex align-items-center justify-content-between"
    >
        <div class="dark-light-btn d-flex align-items-center gap-2">
            <a class="text-decoration-none text-dark main-btn d-flex align-items-center gap-2" href="{{route('site.mode', ['mode' => 'light'])}}">
                <i class="fa-solid fa-sun"></i>
                <p class="m-0">@lang('site.BRIGHT_MODE')</p>
            </a>
            <a class="text-decoration-none text-dark third-btn d-flex align-items-center gap-2" href="{{route('site.mode', ['mode' => 'dark'])}}">
                <i class="fa-solid fa-moon"></i>
                <p class="m-0">@lang('site.DARK_MODE')</p>
            </a>
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