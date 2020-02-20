@extends('layouts.app')

@section('content')
    <section class="auth-form">
        <div class="container">
            <div class="row">
                <div class="">
                    <div class="panel panel-login">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a href="#" class="active" id="login-form-link">@lang('app.login')</a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="#" id="register-form-link">@lang('app.register')</a>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="panel-body">

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{session('error')}}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-12">
                                    <form class="form-horizontal" id="login-form" role="form" style="display: block;"
                                          method="POST" action="{{ route('login_investor') }}">
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
                                                    @lang('app.login_with_tledger')
                                                </button>

                                            </div>
                                            <div class="col-md-8 col-md-offset-4">

                                                <a class="btn btn-link forgot-password"
                                                   href="{{ route('password.request') }}">
                                                    <i class="fa fa-question"></i> @lang('app.forgot_your_password')
                                                </a>
                                            </div>
                                        </div>
                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <div class="col-md-8 col-md-offset-4">--}}
                                        {{--                                                <span>@lang('app.new_on_startupfund')</span>--}}

                                        {{--                                                <a class="btn btn-link" href="{{ route('register') }}">--}}
                                        {{--                                                    @lang('app.create_account')--}}
                                        {{--                                                </a>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                    </form>

                                    <form id="register-form" class="form-horizontal" role="form" method="POST"
                                          action="{{ route('register') }}" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="type" value="{{\App\User::USER_TYPE_INVESTOR_BUISNESS_ANGEL}}">
                                        <div class="form-group{{ ($errors->has('name') or (session()->has('tledger.registration.errors') and array_key_exists('startup_name',session('tledger.registration.errors'))))? ' has-error' : '' }}">
                                            <label for="name" class="col-md-4 control-label">@lang('app.name')</label>

                                            <div class="col-md-8">
                                                <input id="name" type="text" class="form-control" name="name"
                                                       value="{{ old('name') }}" required autofocus>

                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                    @if (session()->has('tledger.registration.errors') and array_key_exists('name',session('tledger.registration.errors')))
                                                        <span class="help-block">
                                                        <strong>{{ session('tledger.registration.errors')['name'] }}</strong>
                                                    </span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div id="first-name" class="form-group{{ ($errors->has('first_name') or (session()->has('tledger.registration.errors') and array_key_exists('first_name',session('tledger.registration.errors')))) ? ' has-error' : '' }}">
                                            <label for="first_name" class="col-md-4 control-label">@lang('app.first_name')</label>

                                            <div class="col-md-8">
                                                <input id="first-name-field" type="text" class="form-control" name="first_name"
                                                       value="{{ old('first_name') }}" autofocus>

                                                @if ($errors->has('first_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('first_name') }}</strong>
                                                    </span>
                                                @endif
                                                @if (session()->has('tledger.registration.errors') and array_key_exists('first_name',session('tledger.registration.errors')))
                                                    <span class="help-block">
                                                        <strong>{{ session('tledger.registration.errors')['first_name'] }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ ($errors->has('email') or (session()->has('tledger.registration.errors') and array_key_exists('email',session('tledger.registration.errors')))) ? ' has-error' : '' }}">
                                            <label for="email"
                                                   class="col-md-4 control-label">@lang('app.email_address')</label>

                                            <div class="col-md-8">
                                                <input id="email" type="email" class="form-control" name="email"
                                                       value="{{ old('email') }}" required>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif

                                                @if (session()->has('tledger.registration.errors') and array_key_exists('email',session('tledger.registration.errors')))
                                                    <span class="help-block">
                                                        <strong>{{ session('tledger.registration.errors')['email'] }}</strong>
                                                    </span>
                                                @endif

                                            </div>
                                        </div>
                                        {{--   --}}
                                        <div id="phone-number"
                                             class="form-group{{ ($errors->has('phone') or (session()->has('tledger.registration.errors') and array_key_exists('phone',session('tledger.registration.errors')))) ? ' has-error' : '' }}">
                                            <label for="phone"
                                                   class="col-md-4 control-label">@lang('app.phone_number')</label>

                                            <div class="col-md-8">
                                                <input id="phone" type="phone" class="form-control" name="phone"
                                                       value="{{ old('phone') }}">

                                                @if ($errors->has('phone'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('phone') }}</strong>
                                                    </span>
                                                @endif
                                                @if (session()->has('tledger.registration.errors') and array_key_exists('phone',session('tledger.registration.errors')))
                                                    <span class="help-block">
                                                        <strong>{{ session('tledger.registration.errors')['phone'] }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ ($errors->has('password') or (session()->has('tledger.registration.errors') and array_key_exists('password',session('tledger.registration.errors')))) ? ' has-error' : '' }}">
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
                                                @if (session()->has('tledger.registration.errors') and array_key_exists('password',session('tledger.registration.errors')))
                                                    <span class="help-block">
                                                        <strong>{{ session('tledger.registration.errors')['password'] }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ ($errors->has('password_confirmation') or (session()->has('tledger.registration.errors') and array_key_exists('password_confirmation',session('tledger.registration.errors')))) ? ' has-error' : '' }}">

                                        <label for="password-confirm"
                                                   class="col-md-4 control-label">@lang('app.confirm_password')</label>

                                            <div class="col-md-8">
                                                <input id="password-confirm" type="password" class="form-control"
                                                       name="password_confirmation" required>
                                                @if ($errors->has('password_confirmation'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                                @endif
                                                @if (session()->has('tledger.registration.errors') and array_key_exists('password_confirmation',session('tledger.registration.errors')))
                                                    <span class="help-block">
                                                        <strong>{{ session('tledger.registration.errors')['password_confirmation'] }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('cgu') ? ' has-error' : '' }}">
                                            <div class="col-md-4"></div>

                                            <div class="col-md-8">
                                                <div class="checkbox checkbox-inline">
                                                    <input type="checkbox" name="cgu"  id="cgu" {{ old('cgu') ? 'checked' : '' }} required>
                                                    <label for="cgu"> @lang('app.register_cgu') </label>
                                                    @if ($errors->has('cgu'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('cgu') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                        @if(get_option('enable_recaptcha_registration') == 1)
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
                                            <div class="col-md-8 col-md-offset-4">
                                                <button type="submit" class="btn main-btn main-btn-gradient">
                                                    @lang('app.register')
                                                </button>
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