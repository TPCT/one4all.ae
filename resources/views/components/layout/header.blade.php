
<div class="navigation-container">
    <x-layout.top-header-menu></x-layout.top-header-menu>
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
                        @if ($client)
                            <a
                                   href="{{route('profile.edit')}}" class="mobile-personal p-3 py-0 d-flex align-items-center gap-3 bg-light shadow-sm rounded-1 text-decoration-none text-dark"
                            >
                                <p>@lang('site.HELLO_USER') {{$client->first_name . " " . $client->last_name}}</p>
                            </a>
                        @else
                            <div class="auth-mobile">
                                <div class="nav-item">
                                    <a class="nav-link px-2" href="{{route('auth.login')}}"
                                    >@lang('site.LOGIN')</a
                                    >
                                </div>
                                <a
                                        href="{{route('auth.register')}}"
                                        class="main-btn d-flex align-items-center"
                                >
                                    @lang('site.REGISTER')
                                </a>
                            </div>
                        @endif

                        <a
                                class="m-0 ms-2 navbar-brand logo text-center d-flex align-items-center"
                                href="{{route('site.index')}}"
                        >
                            <x-curator-glider
                                :media="$logo"
                                class="logo-img mw-100"
                                id="logo-img"
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
                                    <a href="{{$child->link}}" class="main-link {{\App\Helpers\Utilities::getActiveLink($child)}}">
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
                    @if ($client)
                        <a href="{{route('profile.edit')}}" class="personal-login p-3 py-1 d-flex align-items-center gap-3 bg-light shadow-sm rounded-5 text-decoration-none text-dark">
                            <p>@lang('site.HELLO_USER') {{$client->first_name . " " . $client->last_name}}</p>
                        </a>
                    @else
                        <ul
                                class="navbar-nav flex-row navbar-nav-two gap-4 pe-0 mb-2 mb-lg-0"
                        >
                            <li class="nav-item mb-2">
                                <a
                                        class="nav-link px-2"
                                        href="{{route('auth.login')}}"
                                >
                                    @lang('site.LOGIN')
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a
                                        href="{{route('auth.register')}}"
                                        class="main-btn d-flex align-items-center"
                                >
                                    @lang('site.REGISTER')
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </header>
</div>