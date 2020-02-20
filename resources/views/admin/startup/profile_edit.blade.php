@extends('layouts.tow_column_layout')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection
@php
    $auth_user = \Illuminate\Support\Facades\Auth::user();
@endphp
@section('body-class', 'profile-edit-step-1')
@section('content')

    @include('admin.flash_msg')

    <div>
        {{ Form::open(['route'=>'startup_post_profile_edit', 'id'=>'register-form', 'class' => 'form-horizontal', 'files' => true]) }}
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="col-sm-2 active">
                <a href="#your_company" aria-controls="your_company" role="tab" data-toggle="tab">@lang('app.your_company')</a>
            </li>
            <li role="presentation" class="col-sm-2">
                <a href="#teams" aria-controls="teams" class="pointer" role="tab" data-toggle="tab">@lang('app.teams')</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

            <div role="tabpanel" class="tab-pane active" id="your_company">
                <section class="auth-form register">
                    <div class="">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="form-group{{ $errors->has('startup_name') ? ' has-error' : '' }}">
                                    <label for="startup_name"
                                           class="col-md-12 control-label">@lang('app.legal_name_of_the_company')
                                        * </label>
                                    <div class="col-md-12">
                                        <input id="startup_name" type="text" class="form-control" name="startup_name"
                                               value="{{ $user->startup_name }}" required>
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
                                               value="{{ $user->website }}">

                                        @if ($errors->has('website'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('website') }}</strong>
                                                    </span>
                                        @endif

                                    </div>
                                </div>

                                <div class="form-group  {{ $errors->has('logo')? 'has-error':'' }}">
                                    <label class="col-md-12 control-label">@lang('app.upload_the_logo_your_company')
                                        * </label>
                                    <div class="col-md-12 upload-wrapper">

                                        <div class="upload-btn-wrapper">
                                            <button class="btn">@lang('app.upload_file')</button>
                                            <input type="file" id="logo" name="logo" value="{{ $user->logo }}">

                                            <img id="logo-img-preview" class="hidden" src="http://placehold.it/180"
                                                 alt="your image" width="50px"/>
                                        </div>
                                        @if($user->logo)
                                            <a id="logo-url" class="urlto" href="{{ asset('uploads/users/') }}/{{$user->id}}/{{$user->logo}}" target="_blank">{{ $user->logo }}</a>
                                        @endif
                                        {!! $errors->has('logo')? '<p class="help-block">'.$errors->first('logo').'</p>':'' !!}
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('legal_form') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label">@lang('app.legal_form') *</label>

                                    <div class="col-md-8" id="user-type">

                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" id="legal_form_sa"
                                                   value="sa" name="legal_form"
                                                   @if( $user->legal_form == 'sa') checked="checked" @endif
                                            >
                                            <label for="legal_form_sa">SA</label>
                                        </div>
                                        <div class="radio radio-info radio-inline">
                                            <input
                                                    type="radio"
                                                    id="legal_form"
                                                    value="process_transformation"
                                                    name="legal_form"
                                                    @if( $user->legal_form == 'process_transformation') checked="checked" @endif>
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
                                                   value="{{ $user->company_identity }}">
                                            <img id="company_identity-img-preview" class="hidden" src=""
                                                 alt="your image" width="50px"/>
                                        </div>
                                        @if($user->company_identity)
                                            <a id="logo-company_identity" class="urlto" href="{{ asset('uploads/users/') }}/{{$user->id}}/{{$user->company_identity}}" target="_blank">{{ $user->company_identity }}</a>
                                        @endif
                                        {!! $errors->has('company_identity')? '<p class="help-block">'.$errors->first('company_identity').'</p>':'' !!}
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('unique_identifier') ? ' has-error' : '' }}">
                                    <label for="unique_identifier"
                                           class="col-md-12 control-label">@lang('app.unique_identifier_of_the_company')
                                        * </label>

                                    <div class="col-md-12">
                                        <input id="unique_identifier" type="text" class="form-control"
                                               name="unique_identifier"
                                               value="{{ $user->unique_identifier }}" required>

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
                                                    @if( $user->startup_act_label == '1') checked="checked" @endif
                                            >
                                            <label for="startup_act_label1"> @lang('app.yes') </label>
                                        </div>
                                        <div class="radio radio-info radio-inline">
                                            <input
                                                    type="radio"
                                                    id="startup_act_label0"
                                                    value="0"
                                                    name="startup_act_label"
                                                    @if( $user->startup_act_label == '0') checked="checked" @endif
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

                    </div>
                </section>
            </div>

            <div role="tabpanel" class="tab-pane" id="teams">
                <div class="form-group {{ $errors->has('function_team')? 'has-error':'' }}">
                    <div class="col-sm-12">
                        <div class="panel-body teams-block">
                            <div class="content">
                                @if($user->teams()->count() > 0)
                                    @foreach($user->teams()->get() as $teamIndex=>$team)
                                        <div class="row item-team" data-index="{{$teamIndex}}">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-12 control-label">@lang('app.fonction')</label>
                                                    <div class="col-md-12">
                                                        <select class="form-control" name="function_team[]">
                                                            <option value="CEO"  @if($team->fonction == 'CEO') selected @endif >CEO</option>
                                                            <option value="CT0"  @if($team->fonction == 'CTO') selected @endif >CTO</option>
                                                            <option value="COO"  @if($team->fonction == 'COO') selected @endif >COO</option>
                                                            <option value="CSO"  @if($team->fonction == 'CSO') selected @endif >CSO</option>
                                                            <option value="CMO"  @if($team->fonction == 'CSO') selected @endif >CMO</option>
                                                            <option value="CFO"  @if($team->fonction == 'CFO') selected @endif >CFO</option>
                                                        </select>
                                                    </div>
                                                    <label class="remove-team">@lang('app.remove')</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-12 control-label">@lang('app.name')
                                                        /@lang('app.first_name') *</label>
                                                    <div class="col-md-12">
                                                        <input type="text" class="form-control" value="{{$team->name}}" required
                                                               name="name_team[]">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 social-network-link" data-index="{{$teamIndex}}">
                                                <div class="form-group">
                                                    <label class="col-md-12 control-label">@lang('app.social_network_link')
                                                        </label>
                                                    <?php
                                                    $socialNetworks = json_decode($team->social_network_link, true);
                                                    $socialIcons = ['linkedin', 'facebook', 'twitter']
                                                    ?>
                                                    @foreach($socialIcons as $index=>$socialNetwork)
                                                        <div class="item-link input-group">
                                                            <span class="input-group-addon {{$socialIcons[$index]}}"><i
                                                                        class="fa fa-{{$socialIcons[$index]}}"></i></span>
                                                            @php
                                                                if(array_key_exists($index,$socialNetworks)){
                                                                   echo '<input type="text" class="form-control social_network_link" value="'.$socialNetworks[$index].'" name="social_network_team['.$teamIndex.']['.$index.']">';
                                                                }else{
                                                                   echo '<input type="text" class="form-control social_network_link" name="social_network_team['.$teamIndex.']['.$index.']">';
                                                                }
                                                            @endphp
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row item-team " data-index="0">
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
                                                <label class="remove-team">@lang('app.remove')</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">@lang('app.name')
                                                    /@lang('app.first_name') *</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" required
                                                           name="name_team[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 social-network-link" data-index="0">
                                            <div class="form-group">
                                                <label class="col-md-12 control-label">@lang('app.social_network_link')
                                                    </label>
                                                <div class="item-link input-group">
                                                    <span class="input-group-addon linkedin"><i
                                                                class="fa fa-linkedin"></i></span>
                                                    <input type="text" class="form-control social_network_link"
                                                           name="social_network_team[0][0]">
                                                </div>
                                                <div class="item-link input-group">
                                                    <span class="input-group-addon facebook"><i
                                                                class="fa fa-facebook"></i></span>
                                                    <input type="text" class="form-control social_network_link"
                                                           name="social_network_team[0][1]">
                                                </div>
                                                <div class="item-link input-group">
                                                    <span class="input-group-addon twitter"><i
                                                                class="fa fa-twitter"></i></span>
                                                    <input type="text" class="form-control social_network_link"
                                                           name="social_network_team[0][2]">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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

        </div>
        <!-- End Tabs -->
        {{ Form::close() }}
        @include('team_template')
    </div>
@endsection

@section('page-js')
    <script type="text/javascript">
    function readURL(input, id){
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e){
                $('#' + id).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
    <script>
        $(document).ready(function (){
            $('input[type="file"]').change(function(){

                $(this).closest('.upload-wrapper').find('.urlto').html($(this).val())
                $(this).closest('.upload-wrapper').find('.urlto').attr('href',"#")
                $(this).parent().find('img').removeClass('hidden');
                var id = $(this).parent().find('img').attr('id');
                readURL(this, id);
            });
            $('.radio.radio-info input').change(function (){
                $("#profile-step1 .block").addClass("disabled");
                $(this).closest(".block").removeClass("disabled");
            });
            // var i = 0;
            $('.teams-block  .bottom > .add-item').click(function (){
                var i = $(".teams-block .item-team").length
                $('.template-item-team .social-network-link').attr('data-index', i)
                $('.template-item-team .social-network-link .item-link input').attr('name', 'social_network_team[' + i + '][]')
                $('.teams-block > .content').append(
                    $('.template-item-team').html()
                );
            });
            $(document).on('click', '.add-item.small', function (){
                var index = $(this).closest('.social-network-link').attr('data-index')
                $('.template-item-link input').attr('name', 'social_network_team[' + index + '][]')
                $(this).closest(".teams-block .form-group").append(
                    $('.template-item-link').html()
                );
            });
            $(document).on('click', '.remove-item', function (){
                $(this).closest(".item-link").remove();
            });

            $(document).on('click', '.remove-team', function (){
                $(this).closest(".item-team").remove();
                $('.teams-block .item-team').each(function (index1){
                    $('.social_network_link', this).each(function (index2){
                        $(this).attr('name', "social_network_team[" + index1 + "][" + index2 + "]");
                    });
                });
            });
        });
    </script>
@endsection