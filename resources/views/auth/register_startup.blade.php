@extends('layouts.app')

@section('content')
    <section class="auth-form register">
        <div class="">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{session('error')}}
                    </div>
                @endif
                {{ Form::open(['route'=>'register_startup', 'id'=>'register-form', 'class' => 'form-horizontal', 'files' => true]) }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel">
                            <div>
                                <h1 class="page-header"><span class="border-bottom"> @lang('app.you')  </span></h1>
                            </div>

                            <input type="hidden"
                                   value="{{\App\User::USER_TYPE_STARTUP}}" name="type">

                            <div class="panel-body">
                                <div class="form-group{{ $errors->has('name') or $errors->has('first_name') ? ' has-error' : '' }}">
                                    <div class="col-md-6">
                                        <label for="name" class="control-label">@lang('app.name') *</label>
                                        <div>
                                            <input id="name" type="text" class="form-control" name="name"
                                                   value="{{ old('name') }}" required>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name" class="control-label">@lang('app.first_name') *</label>
                                        <div>
                                            <input id="name" type="text" class="form-control" name="first_name"
                                                   value="{{ old('first_name') }}" required>

                                            @if ($errors->has('first_name'))
                                                <span class="help-block">
                                                        <strong>{{ $errors->first('first_name') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <div class="col-md-6 {{ ($errors->has('phone') or (session()->has('tledger.registration.errors') and array_key_exists('phone',session('tledger.registration.errors')))) ? ' has-error' : '' }}">
                                        <label for="phone"
                                               class="control-label">@lang('app.phone_number') *</label>
                                        <div>
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
                                    <div class="col-md-6 {{ ($errors->has('email') or (session()->has('tledger.registration.errors') and array_key_exists('email',session('tledger.registration.errors')))) ? ' has-error' : '' }}" >
                                        <label for="email"
                                               class="col-md-12 control-label">@lang('app.email_address') *</label>
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

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password"
                                           class="col-md-12 control-label">@lang('app.password') *</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control"
                                               name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                                    <label for="password-confirm"
                                           class="col-md-12 control-label">@lang('app.confirm_password') *</label>

                                    <div class="col-md-12">
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('cgu') ? ' has-error' : '' }}">
                                    <div class="col-md-12"></div>

                                    <div class="col-md-12">
                                        <div class="checkbox checkbox-inline">
                                            <input type="checkbox" name="cgu" id="cgu"
                                                   {{ old('cgu') ? 'checked' : '' }} required>
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
                            </div>
                        </div>
                        <div class="panel">
                            <div>
                                <h1 class="page-header"><span class="border-bottom">@lang('app.Funds_sought')</span>
                                </h1>
                            </div>
                            <div class="panel-body">
                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label for="title"
                                           class="col-md-12 control-label">@lang('app.title') *</label>
                                    <div class="col-md-12">
                                        <input id="title" type="text" class="form-control" name="title"
                                               value="{{ old('title') }}" required>
                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group  {{ $errors->has('public_presentation')? 'has-error':'' }}">
                                    <label class="col-md-12 control-label">@lang('app.public_presentation_file') *</label>
                                    <div class="col-md-12 upload-wrapper">

                                        <div class="upload-btn-wrapper">
                                            <button class="btn">@lang('app.upload_file')</button>
                                            <input type="file" id="public_presentation" name="public_presentation"
                                                   value="{{ old('public_presentation') }}" class="" required>
                                            <img id="public_presentation-img-preview" class="hidden" src="" alt="your image" width="50px"/>
                                        </div>

                                        {!! $errors->has('public_presentation')? '<p class="help-block">'.$errors->first('public_presentation').'</p>':'' !!}
                                    </div>
                                </div>

                                <div class="form-group  {{ $errors->has('other_document')? 'has-error':'' }}">
                                    <label class="col-md-12 control-label">@lang('app.other_document')</label>
                                    <div class="col-md-12 upload-wrapper">

                                        <div class="upload-btn-wrapper">
                                            <button class="btn">@lang('app.upload_file')</button>
                                            <input type="file" id="other_document" name="other_document"
                                                   value="{{ old('other_document') }}" class="">
                                            <img id="other_document-img-preview" class="hidden" src="" alt="your image" width="50px"/>
                                        </div>
                                        {!! $errors->has('other_document')? '<p class="help-block">'.$errors->first('other_document').'</p>':'' !!}
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('video') ? ' has-error' : '' }}">
                                    <label for="video"
                                           class="col-md-12 control-label">Youtube</label>

                                    <div class="col-md-12">
                                        <input id="video" type="text" class="form-control" name="video"
                                               value="{{ old('video') }}">

                                        @if ($errors->has('video'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('video') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('goal') ? ' has-error' : '' }}">
                                    <label
                                           class="col-md-12 control-label">@lang('app.Amount_run18months')</label>

                                    <div class="col-md-12 range-block">
                                        <div class="row">
                                            <div class="col-sm-6"><span>Min</span></div>
                                            <div class="col-sm-6" align="right"><span>Max</span></div>
                                        </div>

                                        <input type="range" name="goal" value=@if(old('goal')) "{{ old('goal') }}" @else "200" @endif step="10" min="200" max="1000">
                                        <div class="row">
                                        <div class="col-sm-4" align="left"><span>200 K {{ get_option('currency_sign') }}</span></div>
                                        <div class="col-sm-4" align="center"><output>@if(old('goal')) {{ old('goal') }} @else 200 @endif</output></div>
                                        <div class="col-sm-4" align="right"><span>1000 K {{ get_option('currency_sign') }}</span></div></div>
                                        @if ($errors->has('goal'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('goal') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                                    <label for="companion_duration"
                                           class="col-md-12 control-label">@lang('app.duration_of_the_companion')</label>

                                    <div class="col-md-12">
                                        <select id="companion_duration" class="form-control" name="companion_duration">
                                            <option value="1">1 @lang('app.month')</option>
                                            <option value="2">2 @lang('app.month')</option>
                                            <option value="3">3 @lang('app.month')</option>
                                            <option value="4">4 @lang('app.month')</option>
                                            <option value="4">6 @lang('app.month')</option>
                                        </select>
                                        @if ($errors->has('companion_duration'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('companion_duration') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel">
                            <div>
                                <h1 class="page-header"><span class="border-bottom"> @lang('app.your_company')</span>
                                </h1>
                            </div>
                            <div class="panel-body">

                                <div class="form-group{{ $errors->has('startup_name') ? ' has-error' : '' }}">
                                    <label for="startup_name"
                                           class="col-md-12 control-label">@lang('app.legal_name_of_the_company') * </label>
                                    <div class="col-md-12">
                                        <input id="startup_name" type="text" class="form-control" name="startup_name"
                                               value="{{ old('startup_name') }}" required>
                                        @if ($errors->has('startup_name'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('startup_name') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                                    <label for="website"
                                           class="col-md-12 control-label">@lang('app.link_to_the_project_society_website')</label>

                                    <div class="col-md-12">
                                        <input id="website" type="text" class="form-control" name="website"
                                               value="{{ old('website') }}">

                                        @if ($errors->has('website'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('website') }}</strong>
                                                    </span>
                                        @endif

                                    </div>
                                </div>

                                <div class="form-group  {{ $errors->has('logo')? 'has-error':'' }}">
                                    <label class="col-md-12 control-label">@lang('app.upload_the_logo_your_company') * </label>
                                    <div class="col-md-12 upload-wrapper">

                                        <div class="upload-btn-wrapper">
                                            <button class="btn">@lang('app.upload_file')</button>
                                            <input type="file" id="logo" name="logo"
                                                   value="{{ old('logo') }}" class="" required>
                                            <img id="logo-img-preview" class="hidden" src="http://placehold.it/180" alt="your image" width="50px" />
                                        </div>

                                        {!! $errors->has('logo')? '<p class="help-block">'.$errors->first('logo').'</p>':'' !!}
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('legal_form') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">@lang('app.legal_form') *</label>

                                    <div class="col-md-8" id="user-type">

                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" id="legal_form_sa"
                                                   value="sa" name="legal_form"
                                                   @if( old('legal_form') == 'sa') checked="checked" @endif
                                            >
                                            <label for="legal_form_sa">SA</label>
                                        </div>
                                        <div class="radio radio-info radio-inline">
                                            <input
                                                    type="radio"
                                                    id="legal_form"
                                                    value="process_transformation"
                                                    name="legal_form"
                                                    @if( old('legal_form') == 'process_transformation') checked="checked" @endif
                                            >
                                            <label for="legal_form"> @lang('app.in_the_process_of_transformation')
                                            </label>
                                        </div>
                                        @if ($errors->has('legal_form'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('legal_form') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group  {{ $errors->has('company_identity')? 'has-error':'' }}">
                                    <label class="col-md-12 control-label">@lang('app.update_trade_register') *</label>
                                    <div class="col-md-12 upload-wrapper">

                                        <div class="upload-btn-wrapper">
                                            <button class="btn">@lang('app.upload_file')</button>
                                            <input type="file" id="company_identity" name="company_identity"
                                                   value="{{ old('company_identity') }}" class="" required>
                                            <img id="company_identity-img-preview" class="hidden" src="" alt="your image" width="50px" />
                                        </div>

                                        {!! $errors->has('company_identity')? '<p class="help-block">'.$errors->first('company_identity').'</p>':'' !!}
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('unique_identifier') ? ' has-error' : '' }}">
                                    <label for="unique_identifier"
                                           class="col-md-12 control-label">@lang('app.unique_identifier_of_the_company') * </label>

                                    <div class="col-md-12">
                                        <input id="unique_identifier" type="text" class="form-control"
                                               name="unique_identifier"
                                               value="{{ old('unique_identifier') }}" required>

                                        @if ($errors->has('unique_identifier'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('unique_identifier') }}</strong>
                                                    </span>
                                        @endif

                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">@lang('app.label_startup_act')</label>

                                    <div class="col-md-8" id="user-type">

                                        <div class="radio radio-info radio-inline">
                                            <input
                                                    type="radio" id="startup_act_label1"
                                                    value="1" name="startup_act_label"
                                                    @if( old('startup_act_label') == '1') checked="checked" @endif
                                            >
                                            <label for="startup_act_label1"> @lang('app.yes') </label>
                                        </div>
                                        <div class="radio radio-info radio-inline">
                                            <input
                                                    type="radio"
                                                    id="startup_act_label0"
                                                    value="0"
                                                    name="startup_act_label"
                                                    @if( old('startup_act_label') == '0') checked="checked" @endif
                                            >
                                            <label for="startup_act_label0"> @lang('app.no') </label>
                                        </div>
                                        @if ($errors->has('type'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('type') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="panel">
                            <div>
                                <h1 class="page-header"><span class="border-bottom">@lang('app.teams')</span></h1>
                            </div>

                            <div class="panel-body teams-block">
                                <div class="content">
                                    <div class="row item-team">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">@lang('app.fonction')</label>
                                                <div class="col-md-12">
                                                    <select class="form-control" name="function_team[]">
                                                        <option value="CEO">CEO</option>
                                                        <option value="CT0">CTO</option>
                                                        <option value="COO">COO</option>
                                                        <option value="CSO">CSO</option>
                                                        <option value="CMO">CMO</option>
                                                        <option value="CFO">CFO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">@lang('app.name')
                                                    /@lang('app.first_name')*</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control"
                                                           name="name_team[]" required>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 social-network-link" data-index="0">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">@lang('app.social_network_link')</label>
                                                <div class="item-link input-group">
                                                    <span class="input-group-addon linkedin"><i class="fa fa-linkedin"></i></span>
                                                    <input type="text" class="form-control social_network_link" name="social_network_team[0][0]">
                                                </div>
                                                <div class="item-link input-group">
                                                    <span class="input-group-addon facebook"><i class="fa fa-facebook"></i></span>
                                                    <input type="text" class="form-control social_network_link" name="social_network_team[0][1]">
                                                </div>
                                                <div class="item-link input-group">
                                                    <span class="input-group-addon twitter"><i class="fa fa-twitter"></i></span>
                                                    <input type="text" class="form-control social_network_link" name="social_network_team[0][2]">
                                                </div>
{{--                                                <div class="col-md-12 item-link">--}}
{{--                                                    <input id="social_network_link" type="text" class="form-control"--}}
{{--                                                           name="social_network_team[0][0]"  value="" required>--}}
{{--                                                </div>--}}

{{--                                                <div class="col-md-12 item-link">--}}
{{--                                                    <input id="social_network_link" type="text" class="form-control"--}}
{{--                                                           name="social_network_team[0][1]"  value="" required>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-12 item-link">--}}
{{--                                                    <input id="social_network_link" type="text" class="form-control"--}}
{{--                                                           name="social_network_team[0][2]"  value="" required>--}}
{{--                                                </div>--}}

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bottom" align="center">
                                    <span class="add-item">+</span>
                                </div>
                                <br>
                                <p class="info"> * @lang('app.startup_teams_notice')</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group action-group">
                    <div align="center">
                        <button type="submit" class="btn btn-primary">@lang('app.validated')</button>
                    </div>
                </div>
            {{ Form::close() }}
            @include('team_template')
            <script type="text/javascript">
                function readURL(input, id) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#' + id).attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }

            </script>

        </div>
    </section>
@endsection

@section('page-js')
    <script>

        $(document).ready(function (){

            $('input[type="file"]').change(function(){
               $(this).parent().find('img').removeClass('hidden');
                var id = $(this).parent().find('img').attr('id');
                readURL(this, id);
            });

            var i = 0;

            $('.teams-block  .bottom > .add-item').click(function (){
                i++;
                $('.template-item-team .social-network-link').attr('data-index', i)
                $('.template-item-team .social-network-link .item-link input').attr('name', 'social_network_team[' + i + '][]')
                $('.teams-block > .content').append(
                    $('.template-item-team').html()
                );
            });

            $(document).on('click', '.add-item.small', function (){
                var index = $(this).closest('.social-network-link').attr('data-index')
                $('.template-item-link input').attr('name', 'social_network_team[' + index + '][]')
                $(this).closest(".form-group").append(
                    $('.template-item-link').html()
                );
            });
            $(document).on('click', '.remove-item', function (){
                $(this).closest(".item-link").remove();
            });

            $(document).on('click', '.remove-team', function (){
                $(this).closest(".item-team").remove();
                $('.teams-block .item-team').each(function( index1 ) {
                    $('.social_network_link',this).each(function( index2 ) {
                        $(this).attr('name',"social_network_team["+index1+"]["+index2+"]");
                    });
                });
            });

        })
    </script>
@endsection