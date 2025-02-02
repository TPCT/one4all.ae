<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" style="overflow-x: hidden">
    <head>
        <title>
            @if (app(\App\Settings\General::class)->site_title)
                @hasSection('title')
                    @yield('title') -
                @endif
                {{app(\App\Settings\General::class)->site_title[app()->getLocale()] ?? config('app.name')}}
            @endif
        </title>

        <link rel="icon" type="image/x-icon" href="{{asset('/storage/' . \Awcodes\Curator\Models\Media::find(app(\App\Settings\Site::class)->fav_icon)?->path)}}"/>

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <x-layout.seo></x-layout.seo>

        <link type="text/css" rel="stylesheet" href="{{asset('/minify/css/bootstrap.min.css')}}"/>
        <link
                rel="stylesheet"
                type="text/css"
                href="{{asset('/minify/js/slick-1.8.1/slick/slick.css')}}"
        />
        <link rel="stylesheet" type="text/css" href="{{asset('/minify/js/slick-1.8.1/slick/slick-theme.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/intlTelInput.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/fontawesome.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/Layout.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/menu.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/header.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/navbar.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/footer.css')}}" />

        @stack('style')

        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/styles.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/arabic-styles.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/animate.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/home-login.css')}}"/>

        <script src="{{asset('/minify/js/wow.js')}}"></script>

        <script>
            new WOW().init();
        </script>


        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/custom.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/errors.css')}}"/>
    </head>

    <body class="{{app()->getLocale() == "ar" ? "arabic-version" : ""}} {{session('mode', 'light') === "dark" ? "dark-mode" : "light-mode" }}">
        <main id="@yield('id')" class="@yield('class')">
            <x-layout.header></x-layout.header>
            <div id="readspeakerDiv">
                @if ($contact_us_whatsapp_number = app(\App\Settings\Site::class)->contact_us_whatsapp_number)
                    <a href="{{$contact_us_whatsapp_number}}" class="floating-wa">
                        <picture>
                            <img src="{{asset('/assets/icons/logos_whatsapp-icon.png')}}" alt="" />
                        </picture>
                        <p>@lang('site.WHATSAPP_BUTTON')</p>
                    </a>
                @endif
                @yield('content')
            </div>
            <x-layout.footer></x-layout.footer>
        </main>
        {!! NoCaptcha::renderJs() !!}

        <script type="text/javascript" src="{{asset('/minify/js/jquery-3.7.1.js')}}"></script>
        <script type="text/javascript" src="{{asset('/minify/js/intlTelInput.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/minify/js/slick-1.8.1/slick/slick.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/minify/js/bootstrap/popper.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/minify/js/bootstrap/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('/minify/js/menu.js')}}"></script>
        <script type="text/javascript" src="{{asset('/minify/js/main.js')}}"></script>
        <script type="text/javascript" src="{{asset('/minify/js/footer.js')}}"></script>
        <script type="text/javascript" src="{{asset('/minify/js/light-dark-mode.js')}}"></script>
        <script type="text/javascript" src="{{asset('/minify/js/popup.js')}}"></script>

        @stack('script')

        @if ($message = session('success-payment'))
            <script>
                $(function(){
                    const popup = new Popup({
                        id: "board",
                        titleColor: "#000",
                        textColor: "#000",
                        closeColor: "#000",
                        title: `<div class='d-flex flex-column align-items-center'><img class='check' src='{{asset('/assets/imgs/popup/CheckCircle.svg')}}'/>@lang('site.PAYMENT_SUCCESS_POP_UP_TITLE')</div>`,
                        backgroundColor: "#FFF",
                        content: "",
                        showImmediately: true
                    });
                })
            </script>
        @endif

        @if ($message = session('service') || $message = session('package'))
            <script>
                $(function(){
                    const popup = new Popup({
                        id: "board",
                        titleColor: "#000",
                        textColor: "#000",
                        closeColor: "#000",
                        title: `<div class='d-flex flex-column align-items-center'><img class='check' src='{{asset('/assets/imgs/popup/Vector.svg')}}'/>@lang('site.PAYMENT_FAILED_POP_UP_TITLE')</div>`,
                        backgroundColor: "#FFF",
                        content: "",
                        showImmediately: true
                    });
                })
            </script>
        @endif
    </body>
</html>
