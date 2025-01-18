@php use App\Settings\Site; @endphp
<x-layout.top-header-menu></x-layout.top-header-menu>
<div class="navigation-container">
    <div class="main-navigation--container"></div>
    <header class="main-navigation--container">
        <div
                class="hewader-panel-main d-flex position-relative justify-content-between px-0"
        >
            <div
                    class="header-logo container header-custom-container w-100 d-flex flex-row align-items-start align-items-lg-center justify-content-between"
            >
                <div
                        class="header-menu px-0 w-100 d-flex align-items-center justify-content-between"
                >
                    <nav
                            id="cssmenu"
                            class="head_btm_menu d-flex justify-content-xl-between justify-content-end w-100"
                    >
                        <div class="auth-mobile">
                            <div class="nav-item">
                                <a class="nav-link px-2" href="./login-ar.html"
                                >@lang('site.LOGIN')</a
                                >
                            </div>
                            <a
                                    href="./register-ar.html"
                                    class="main-btn d-flex align-items-center"
                            >
                                @lang('site.REGISTER')
                            </a>
                        </div>
                        <a
                                class="m-0 ms-2 navbar-brand logo text-center d-flex align-items-center"
                                href="./home.html"
                        >
                            <img
                                    id="logo-img"
                                    class="logo-img mw-100"
                                    src="{{asset('/assets/imgs/home/logo.png')}}"
                                    alt=""
                            />
                        </a>

                        <ul class="">
                            @foreach($menu->links as $child)
                                @continue(!$child->status)
                                <li class="@if($child->has_children()) has-sub @endif">
                                    @if($child->has_children())
                                        <span class="submenu-button">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                    @endif
                                    <a href="{{$child->link}}" class="main-link @if(!$loop->index) active @endif">
                                        @if ($child->has_children())
                                            <i class="fa-solid fa-chevron-down"></i>
                                        @endif
                                        {{$child->title}}
                                    </a>
                                    @if($child->has_children())
                                        <ul id="sub-cat">
                                            @foreach($child->children as $grandson)
                                                @continue(!$grandson->status)
                                                <li>
                                                    <a href="{{$grandson->link}}" class="main-link">{{$grandson->title}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <div class="navigation-last-content"></div>
                    </nav>
                    <ul
                            class="navbar-nav flex-row navbar-nav-two gap-4 pe-0 mb-2 mb-lg-0"
                    >
                        <li class="nav-item mb-2">
                            <a
                                   class="nav-link px-2"
                                   href="./login-ar.html"
                            >
                                @lang('site.LOGIN')
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a
                                href="./register-ar.html"
                                class="main-btn d-flex align-items-center"
                            >
                                @lang('site.REGISTER')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</div>