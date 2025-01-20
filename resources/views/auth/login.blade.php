@extends('layouts.main')

@section('title', __("site.Login"))

@section('id', 'login')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/home.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/authentication.css')}}">
@endpush

@section('content')
    <x-layout.header-image :title="__('site.Login')" :breadcrumbs="[
                __('site.HOME') => route('site.index'),
                __('site.Login') => ''
    ]"/>

    <section class="auth">
        <div class="container">
            <form method="post">
                @csrf
                <div class="head-form mb-5">
                    <div class="d-flex justify-content-center">
                        @if($success_message = session('success'))
                            <div class="my-3 alert alert-success">
                                <span class="">{{$success_message}}</span>
                            </div>
                        @endif
                    </div>


                    <h1>{{$login_page_section->title}}</h1>
                    {!! $login_page_section->description !!}
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label class="mb-2">@lang('site.LOGIN_EMAIL')</label>
                            <input
                                    type="email"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="@lang('site.LOGIN_EMAIL_PLACEHOLDER')"
                            />
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label class="mb-2">@lang('site.LOGIN_PASSWORD')</label>
                            <input
                                    type="password"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="@lang('site.LOGIN_PASSWORD_PLACEHOLDER')"
                            />
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-check mb-3">
                            <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    id="flexCheckDefault"
                            />
                            <label class="form-check-label" for="flexCheckDefault">
                                @lang('site.REMEMBER_ME')
                            </label>
                        </div>
                    </div>
                    <div
                            class="col-lg-10 mb-3 d-flex align-items-center justify-content-end \"
                    >
                        <a href="#">
                            <p>@lang('site.FORGET_PASSWORD')</p>
                        </a>
                    </div>
                </div>
                <button type="submit" class="main-btn w-100 my-3">
                    <span> @lang('site.LOGIN_BUTTON') </span>
                </button>
                <p class="text-center">
                    @lang('site.REGISTER_LOGIN_PAGE_DESCRIPTION')
                    <a href="./login.html">@lang('site.REGISTER')</a>
                </p>
            </form>
        </div>
    </section>
@endsection

@push('script')
@endpush