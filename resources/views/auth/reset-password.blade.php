@extends('layouts.main')

@section('title', __("site.RESET_PASSWORD"))

@section('id', 'login')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/home.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/minify/css/authentication.css')}}">
@endpush

@section('content')
    <x-layout.header-image :title="__('site.RESET_PASSWORD')" :breadcrumbs="[
                __('site.HOME') => route('site.index'),
                __('site.RESET_PASSWORD') => ''
    ]"/>

    <section class="auth">
        <div class="container">
            <form method="post">
                @csrf
                @if($success_message = session('success'))
                    <div class="head-form mb-5 ">
                        <div class="d-flex justify-content-center">
                                <div class="my-3 alert alert-success">
                                    <span class="">{{$success_message}}</span>
                                </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label class="mb-2">@lang('site.LOGIN_EMAIL')</label>
                            <input
                                    name="email"
                                    type="email"
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="@lang('site.LOGIN_EMAIL_PLACEHOLDER')"
                            />
                        </div>
                        @error('email')
                            <span class="text-danger error">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="d-flex w-100 justify-content-center">
                    <button type="submit" class="main-btn my-3">
                        <span> @lang('site.RESET_BUTTON') </span>
                    </button>
                </div>
                <p class="text-center">
                    @lang('site.LOGIN_REGISTER_PAGE_DESCRIPTION')
                    <a href="{{route('auth.login')}}">@lang('site.Login')</a>
                </p>
            </form>
        </div>
    </section>
@endsection

@push('script')
@endpush