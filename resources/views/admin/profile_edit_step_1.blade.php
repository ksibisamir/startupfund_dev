@extends('layouts.tow_column_layout')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection
@php
    $auth_user = \Illuminate\Support\Facades\Auth::user();
@endphp
@section('body-class', 'profile-edit-step-1')
@section('content')
    @if( ! empty($title))
        <div>
            <h1 class="page-header"><span class="border-bottom"> {{ $title }}</span></h1>
        </div> <!-- /.row -->
    @endif

    @include('admin.flash_msg')

    <div>

        {!! Form::open(['class'=>'form-horizontal', 'files'=>'true','id'=>'profile-step1','action' => 'UserController@profileEditStep1Post']) !!}

        @if($auth_user->id != $user->id)
            <input type="hidden"
                   value="{{ old('id')? old('id') : $user->id }}" name="id"
                   required>
        @endif

        <input type="hidden" name="profile" value="{{\App\User::USER_TYPE_INVESTOR_BUISNESS_ANGEL}}">
        <div class="form-group {{ $errors->has('gender')? 'has-error':'' }}">
            <label for="gender" class="col-sm-2 control-label">@lang('app.gender')</label>
            <div class="col-sm-10">
                <select id="gender" name="gender" class="form-control select2">
                    <option value="">Select</option>
                    <option value="mademoiselle" {{ $user->gender == 'mademoiselle'?'selected':'' }}>
                        @lang('app.mademoiselle')
                    </option>
                    <option value="madame" {{ $user->gender == 'madame'?'selected':'' }}>
                        @lang('app.madame')
                    </option>
                    <option value="monsieur" {{ $user->gender == 'monsieur'?'selected':'' }}>
                        @lang('app.monsieur')
                    </option>
                </select>

                {!! $errors->has('gender')? '<p class="help-block">'.$errors->first('gender').'</p>':'' !!}
            </div>
        </div>

        <div class="form-group ">
            <div class="{{ $errors->has('name')? 'has-error':'' }}">
                <label for="name" class="col-sm-2 control-label">@lang('app.name')</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="name"
                           value="{{ old('name')? old('name') : $user->name }}" name="name"
                           required
                           placeholder="@lang('app.name')">
                    {!! $errors->has('name')? '<p class="help-block">'.$errors->first('name').'</p>':'' !!}
                </div>
            </div>
            <!-- Prénom -->
            <div class="{{ $errors->has('first_name')? 'has-error':'' }}">
                <label for="first_name"
                       class="col-sm-2 control-label">@lang('app.first_name')</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="first_name"
                           value="{{ old('first_name')? old('first_name') : $user->first_name }}"
                           required
                           name="first_name"
                           placeholder="@lang('app.first_name')">
                    {!! $errors->has('first_name')? '<p class="help-block">'.$errors->first('first_name').'</p>':'' !!}
                </div>
            </div>

        </div>

        <!-- Date de naissaince -->
        <div class="form-group ">
            <div class="{{ $errors->has('birth_date')? 'has-error':'' }}">
                <label for="birth_date"
                       class="col-sm-2 control-label">@lang('app.birth_date')</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="birth_date"
                           value="{{ old('birth_date')? old('birth_date') : $user->birth_date }}"
                           name="birth_date"
                           placeholder="@lang('app.birth_date')">
                    {!! $errors->has('birth_date')? '<p class="help-block">'.$errors->first('birth_date').'</p>':'' !!}
                </div>
            </div>
            <div class="{{ $errors->has('city_birth')? 'has-error':'' }}">
                <!-- Ville de naissaince -->
                <label for="city_birth"
                       class="col-sm-2 control-label">@lang('app.city_birth')</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="city_birth"
                           value="{{ old('city_birth')? old('city_birth') : $user->city_birth }}"
                           name="city_birth"
                           placeholder="@lang('app.city_birth')">
                    {!! $errors->has('city_birth')? '<p class="help-block">'.$errors->first('city_birth').'</p>':'' !!}
                </div>
            </div>
        </div>
        <!-- Nationalité -->
        <div class="form-group {{ $errors->has('nationality') || $errors->has('cin')? 'has-error':'' }}">
            <label for="nationality"
                   class="col-sm-2 control-label">@lang('app.nationality')*</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nationality"
                       value="{{ old('nationality')? old('nationality') : $user->nationality }}"
                       name="nationality"
                       placeholder="@lang('app.nationality')">
                {!! $errors->has('nationality')? '<p class="help-block">'.$errors->first('nationality').'</p>':'' !!}
            </div>

            <label for="address" class="col-sm-2 control-label">@lang('app.cin_or_passport')</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="cin"
                       value="{{ old('cin')? old('cin') : $user->cin }}" name="cin"
                       placeholder="@lang('app.cin_or_passport')" required>
                {!! $errors->has('cin')? '<p class="help-block">'.$errors->first('cin').'</p>':'' !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('address')? 'has-error':'' }}">
            <label for="address" class="col-sm-2 control-label">@lang('app.address')</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="address"
                       value="{{ old('address')? old('address') : $user->address }}"
                       name="address"
                       placeholder="@lang('app.address')">
                {!! $errors->has('address')? '<p class="help-block">'.$errors->first('address').'</p>':'' !!}
            </div>
        </div>
        <!-- Code postal-->
        <div class="form-group {{ $errors->has('postal_code')? 'has-error':'' }}">
            <label for="postal_code"
                   class="col-sm-2 control-label">@lang('app.postal_code')</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="postal_code"
                       value="{{ old('postal_code')? old('postal_code') : $user->postal_code }}"
                       name="postal_code"
                       placeholder="@lang('app.postal_code')">
                {!! $errors->has('postal_code')? '<p class="help-block">'.$errors->first('postal_code').'</p>':'' !!}
            </div>

            <!-- Ville -->
            <label for="city" class="col-sm-2 control-label">@lang('app.city')</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="city"
                       value="{{ old('city')? old('city') : $user->city }}"
                       name="city"
                       placeholder="@lang('app.city')">
                {!! $errors->has('city')? '<p class="help-block">'.$errors->first('city').'</p>':'' !!}
            </div>

        </div>

        <!-- Governorate -->
        <div class="form-group {{ $errors->has('governorate')? 'has-error':'' }}">
            <label for="governorate"
                   class="col-sm-2 control-label">@lang('app.governorate')</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="governorate"
                       value="{{ old('governorate')? old('governorate') : $user->governorate }}"
                       name="governorate"
                       placeholder="@lang('app.governorate')">
                {!! $errors->has('governorate')? '<p class="help-block">'.$errors->first('governorate').'</p>':'' !!}
            </div>

            <!-- Pays -->
            <label for="phone" class="col-sm-2 control-label">@lang('app.country')</label>
            <div class="col-sm-4">
                <select id="country_id" name="country_id" class="form-control select2">
                    <option value="">@lang('app.select_a_country')</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ $country->name == 'Tunisia' ? 'selected' :'' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->has('country_id')? '<p class="help-block">'.$errors->first('country_id').'</p>':'' !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('email')? 'has-error':'' }}">
            <label for="email" class="col-sm-2 control-label">@lang('app.email')</label>
            <div class="col-sm-4">
                <input type="email" class="form-control" id="email" disabled
                       value="{{ old('email')? old('email') : $user->email }}" name="email"
                       placeholder="@lang('app.email')">
                {!! $errors->has('email')? '<p class="help-block">'.$errors->first('email').'</p>':'' !!}
            </div>

            <label for="phone" class="col-sm-2 control-label">@lang('app.phone')</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="phone" disabled
                       value="{{ old('phone')? old('phone') : $user->phone }}" name="phone"
                       placeholder="@lang('app.phone')">
                {!! $errors->has('phone')? '<p class="help-block">'.$errors->first('phone').'</p>':'' !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('professional_activity')? 'has-error':'' }}">
            <label for="professional_activity"
                   class="col-sm-2 control-label">@lang('app.professional_activity')</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="professional_activity"
                       value="{{ old('professional_activity')? old('professional_activity') : $user->professional_activity }}"
                       name="professional_activity"
                       placeholder="@lang('app.professional_activity')">
                {!! $errors->has('professional_activity')? '<p class="help-block">'.$errors->first('professional_activity').'</p>':'' !!}
            </div>

            <label for="previous_occupation"
                   class="col-sm-2 control-label">@lang('app.previous_occupation')</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="previous_occupation"
                       value="{{ old('previous_occupation')? old('previous_occupation') : $user->previous_occupation }}"
                       name="previous_occupation"
                       placeholder="@lang('app.previous_occupation')">
                {!! $errors->has('previous_occupation')? '<p class="help-block">'.$errors->first('previous_occupation').'</p>':'' !!}
            </div>
        </div>

        <div class="block {{--@if($user->registration_type !='subscribe_certify') disabled @endif--}}">
            <div class="form-group">
                <div class="col-md-12 radio radio-info radio-inline">
                    <input type="radio" class="radio custom-control-input" id="subscribe_certify"
                           value="subscribe_certify"
                           {{--@if($user->registration_type=='subscribe_certify') checked
                           @endif--}}  name="registration_type" required checked>
                    <label for="subscribe_certify">@lang('app.subscribe_certify')</label>
                    @if ($errors->has('subscribe_certify'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('subscribe_certify') }}</strong>
                                    </span>
                    @endif
                </div>
                <ul>
                    <li>@lang('app.subscribe_certify_1')</li>
                    <li>@lang('app.subscribe_certify_2')</li>
                    <li>@lang('app.subscribe_certify_3')</li>
                </ul>
            </div>
        </div>

        {{--<div class="row or-block">
            <div class="col-sm-5 separator"></div>
            <div class="col-sm-2 or"><strong>@lang('app.or')</strong></div>
            <div class="col-sm-5 separator"></div>
        </div>

        <div class="block @if($user->registration_type != 'subscribe_certify') disabled @endif">

            <div class="form-group">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="was_approached"
                           value="was_approached"
                           @if($user->registration_type=='was_approached') checked
                           @endif name="registration_type" required>
                    <label for="was_approached">@lang('app.was_approached')</label>

                </div>
                @if ($errors->has('registration_type'))
                    <span class="help-block">
                                    <strong>{{ $errors->first('registration_type') }}</strong>
                                </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('name')? 'has-error':'' }}">
                <label for="direct_seller_name"
                       class="col-sm-2 control-label">@lang('app.name')</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="direct_seller_name"
                           value="{{ old('direct_seller_name')? old('direct_seller_name') : $user->direct_seller_name }}"
                           name="direct_seller_name"
                           placeholder="@lang('app.name')">
                    {!! $errors->has('direct_seller_name')? '<p class="help-block">'.$errors->first('direct_seller_name').'</p>':'' !!}
                </div>
                <label for="direct_seller_first_name"
                       class="col-sm-2 control-label">@lang('app.first_name')</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="direct_seller_first_name"
                           value="{{ old('direct_seller_first_name')? old('direct_seller_first_name') : $user->direct_seller_first_name }}"
                           name="direct_seller_first_name"
                           placeholder="@lang('app.name')">
                    {!! $errors->has('direct_seller_first_name')? '<p class="help-block">'.$errors->first('direct_seller_first_name').'</p>':'' !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('direct_seller_address')? 'has-error':'' }}">
                <label for="direct_seller_address"
                       class="col-sm-2 control-label">@lang('app.address')</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="address"
                           value="{{ old('direct_seller_address')? old('direct_seller_address') : $user->direct_seller_address }}"
                           name="direct_seller_address"
                           placeholder="@lang('app.address')">
                    {!! $errors->has('direct_seller_address')? '<p class="help-block">'.$errors->first('direct_seller_address').'</p>':'' !!}
                </div>
            </div>
            <!-- Code postal-->
            <div class="form-group {{ $errors->has('direct_seller_postal_code')? 'has-error':'' }}">
                <label for="direct_seller_postal_code"
                       class="col-sm-2 control-label">@lang('app.postal_code')</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="direct_seller_postal_code"
                           value="{{ old('direct_seller_postal_code')? old('direct_seller_postal_code') : $user->direct_seller_postal_code }}"
                           name="direct_seller_postal_code"
                           placeholder="@lang('app.postal_code')">
                    {!! $errors->has('direct_seller_postal_code')? '<p class="help-block">'.$errors->first('direct_seller_postal_code').'</p>':'' !!}
                </div>

                <!-- Ville -->
                <label for="direct_seller_city"
                       class="col-sm-2 control-label">@lang('app.city')</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="direct_seller_city"
                           value="{{ old('direct_seller_city')? old('direct_seller_city') : $user->direct_seller_city }}"
                           name="direct_seller_city"
                           placeholder="@lang('app.city')">
                    {!! $errors->has('direct_seller_city')? '<p class="help-block">'.$errors->first('direct_seller_city').'</p>':'' !!}
                </div>

            </div>

            <!-- Governorate -->
            <div class="form-group {{ $errors->has('direct_seller_governorate')? 'has-error':'' }}">
                <label for="direct_seller_governorate"
                       class="col-sm-2 control-label">@lang('app.governorate')</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="direct_seller_governorate"
                           value="{{ old('direct_seller_governorate')? old('direct_seller_governorate') : $user->direct_seller_governorate }}"
                           name="direct_seller_governorate"
                           placeholder="@lang('app.governorate')">
                    {!! $errors->has('direct_seller_governorate')? '<p class="help-block">'.$errors->first('direct_seller_governorate').'</p>':'' !!}
                </div>

                <!-- Pays -->
                <label for="direct_seller_phone"
                       class="col-sm-2 control-label">@lang('app.country')</label>
                <div class="col-sm-4">
                    <select id="direct_seller_country_id" name="direct_seller_country_id"
                            class="form-control select2">
                        <option value="">@lang('app.select_a_country')</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ $country->name == 'Tunisia' ? 'selected' :'' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    {!! $errors->has('direct_seller_country_id')? '<p class="help-block">'.$errors->first('direct_seller_country_id').'</p>':'' !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('direct_seller_email')? 'has-error':'' }}">
                <label for="direct_seller_email"
                       class="col-sm-2 control-label">@lang('app.email')</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control" id="direct_seller_email"
                           value="{{ old('email')? old('direct_seller_email') : $user->direct_seller_email }}"
                           name="direct_seller_email"
                           placeholder="@lang('app.email')">
                    {!! $errors->has('direct_seller_email')? '<p class="help-block">'.$errors->first('direct_seller_email').'</p>':'' !!}
                </div>

                <label for="direct_seller_phone"
                       class="col-sm-2 control-label">@lang('app.phone')</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="direct_seller_phone"
                           value="{{ old('direct_seller_phone')? old('direct_seller_phone') : $user->direct_seller_phone }}"
                           name="direct_seller_phone"
                           placeholder="@lang('app.phone')">
                    {!! $errors->has('direct_seller_phone')? '<p class="help-block">'.$errors->first('direct_seller_phone').'</p>':'' !!}
                </div>
            </div>

            --}}{{--                            <div class="form-group  {{ $errors->has('photo')? 'has-error':'' }}">--}}{{--
            --}}{{--                                <label class="col-sm-4 control-label">@lang('app.change_avatar')</label>--}}{{--
            --}}{{--                                <div class="col-sm-8">--}}{{--
            --}}{{--                                    <input type="file" id="photo" name="photo" class="filestyle">--}}{{--
            --}}{{--                                    {!! $errors->has('photo')? '<p class="help-block">'.$errors->first('photo').'</p>':'' !!}--}}{{--
            --}}{{--                                </div>--}}{{--
            --}}{{--                            </div>--}}{{--
        </div>
    --}}
        <div class="form-group action-group" align="center">
            <button type="submit" name="btn-action" value="save"
                    class="btn btn-primary">@lang('app.next')</button>
        </div>
        {!! Form::close() !!}
        @include('team_template')
    </div>
@endsection
@section('page-js')
    <script>
        $(document).ready(function (){
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