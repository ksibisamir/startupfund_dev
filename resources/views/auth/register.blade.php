@extends('layouts.app')

@section('content')
    <section>
            <div id="register-form" class="row equal">

                <div class="col-md-6 left-block">
                    {{--<img src="{{ asset('assets/images/svg/inscription.svg') }}" width="100%">--}}
                </div>
                <div class="col-md-6">
                    <div class="register-form">
                        <h1 class="welcome">@lang('app.welcome_startupfund')</h1>
                        <p class="welcome-message">@lang('app.future_tunisia_needs_you_finance_startups_increase_your_income')</p>
                        <p class="info">@lang('app.already_have_account') <a href="{{ route('login') }}">@lang('app.log_in')</a> </p>
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{session('error')}}
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="type" value="{{\App\User::USER_TYPE_INVESTOR_BUISNESS_ANGEL}}">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">@lang('app.name')</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name" class="col-md-4 control-label">@lang('app.first_name')</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ ($errors->has('email') or (session()->has('tledger.registration.errors') and array_key_exists('email',session('tledger.registration.errors')))) ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">@lang('app.email_address')</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

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

                            <div class="form-group{{ ($errors->has('phone') or (session()->has('tledger.registration.errors') and array_key_exists('phone',session('tledger.registration.errors')))) ? ' has-error' : '' }}">
                                <label for="phone"
                                       class="col-md-4 control-label">@lang('app.phone_number')</label>

                                <div class="col-md-6">
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

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">@lang('app.password')</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">@lang('app.confirm_password')</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('cgu') ? ' has-error' : '' }}">
                                <div class="col-md-12 accepte-cgu">
                                    <div class="checkbox checkbox-inline checkbox-info ">
                                        <input type="checkbox" class="custom-control-input" id="cgu" name="cgu" required>
                                        <label for="cgu" >@lang('app.register_cgu')</label>
                                    </div>
                                    @if ($errors->has('cgu'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('cgu') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>



                            @if(get_option('enable_recaptcha_registration') == 1)
                                <div class="form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="g-recaptcha" data-sitekey="{{get_option('recaptcha_site_key')}}"></div>
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
                                    <button type="submit" class="btn btn-primary">
                                        @lang('app.register')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@endsection

@if(get_option('enable_recaptcha_registration') == 1)
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endif