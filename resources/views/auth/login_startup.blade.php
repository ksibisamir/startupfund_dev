@extends('layouts.app')

@section('content')
    <section class="auth-form">
        <div class="container">
            <div class="row">
                <div class="">
                    <div class="panel panel-login">

                        <div class="panel-body">
                            @include('admin.flash_msg')
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{session('error')}}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-12">
                                    <form class="form-horizontal" id="login-form" role="form" style="display: block;"
                                          method="POST" action="{{ route('login_startup') }}">
                                        {{ csrf_field() }}
                                        @if (session()->has('tledger.login.errors'))
                                            <div class="alert alert-danger" role="alert" style="line-height: 2;">
                                                @foreach(session('tledger.login.errors') as $key=>$error)
                                                    <div >{{$key + 1}}.&nbsp;{{ $error }}</div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label for="email"
                                                   class="col-md-4 control-label">@lang('app.email_address')</label>

                                            <div class="col-md-8">
                                                <input id="email" type="email" class="form-control" name="email"
                                                       value="{{ old('email') }}" required autofocus>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label for="password"
                                                   class="col-md-4 control-label">@lang('app.password')</label>

                                            <div class="col-md-8">
                                                <input id="password" type="password" class="form-control"
                                                       name="password" required>

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if(get_option('enable_recaptcha_login') == 1)
                                            <div class="form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                                <div class="col-md-6 col-md-offset-4">
                                                    <div class="g-recaptcha"
                                                         data-sitekey="{{get_option('recaptcha_site_key')}}"></div>
                                                    @if ($errors->has('g-recaptcha-response'))
                                                        <span class="help-block">
                                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <div class="checkbox checkbox-inline checkbox-info ">
                                                    <input type="checkbox" id="remember_me"
                                                           name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label for="remember_me"> @lang('app.remember_me') </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button type="submit" class="btn main-btn main-btn-gradient">
                                                    @lang('app.login')
                                                </button>

                                            </div>
                                            <div class="col-md-8 col-md-offset-4">
                                                <a class="btn btn-link forgot-password"
                                                   href="{{ route('password.request') }}">
                                                    <i class="fa fa-question"></i> @lang('app.forgot_your_password')
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-js')
    <script>
        $(function () {
            @if (session()->has('tledger.registration.errors'))
            $("#investor_business_angel").trigger('click');
            @endif
            if (window.location.hash.substr(1) == "register") {
                $("#register-form").delay(100).fadeIn(100);
                $("#login-form").fadeOut(100);
                $('#login-form-link').removeClass('active');
                $('#register-form-link').addClass('active');
            }
            if (window.location.hash.substr(1) == "login") {
                $("#login-form").delay(100).fadeIn(100);
                $("#register-form").fadeOut(100);
                $('#register-form-link').removeClass('active');
                $('#login-form-link').addClass('active');
            }
        });
    </script>
@endsection