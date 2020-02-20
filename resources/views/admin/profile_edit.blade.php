@extends('layouts.tow_column_layout')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection
@php
    $auth_user = \Illuminate\Support\Facades\Auth::user();
@endphp

@section('content')
    @if( ! empty($title))
        <div>
            <h1 class="page-header"> {{ $title }}  </h1>
        </div> <!-- /.row -->
    @endif

    @include('admin.flash_msg')

    <div class="row">
        <div class="col-xs-12">
            {!! Form::open(['class'=>'form-horizontal', 'files'=>'true']) !!}
            <div class="form-group {{ $errors->has('name')? 'has-error':'' }}">
                <label for="name" class="col-sm-4 control-label">@lang('app.name')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="name"
                           value="{{ old('name')? old('name') : $user->name }}" name="name"
                           placeholder="@lang('app.name')">
                    {!! $errors->has('name')? '<p class="help-block">'.$errors->first('name').'</p>':'' !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('email')? 'has-error':'' }}">
                <label for="email" class="col-sm-4 control-label">@lang('app.email')</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" id="email"
                           value="{{ old('email')? old('email') : $user->email }}" name="email"
                           placeholder="@lang('app.email')">
                    {!! $errors->has('email')? '<p class="help-block">'.$errors->first('email').'</p>':'' !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('gender')? 'has-error':'' }}">
                <label for="gender" class="col-sm-4 control-label">@lang('app.gender')</label>
                <div class="col-sm-8">
                    <select id="gender" name="gender" class="form-control select2">
                        <option value="">Select</option>
                        <option value="mademoiselle" {{ $user->gender == 'mademoiselle'?'selected':'' }}>@lang('app.mademoiselle')</option>
                        <option value="madame" {{ $user->gender == 'madame'?'selected':'' }}>@lang('app.madame')</option>
                        <option value="monsieur" {{ $user->gender == 'monsieur'?'selected':'' }}>@lang('app.monsieur')</option>
                    </select>

                    {!! $errors->has('gender')? '<p class="help-block">'.$errors->first('gender').'</p>':'' !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('phone')? 'has-error':'' }}">
                <label for="phone" class="col-sm-4 control-label">@lang('app.phone')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="phone"
                           value="{{ old('phone')? old('phone') : $user->phone }}" name="phone"
                           placeholder="@lang('app.phone')">
                    {!! $errors->has('phone')? '<p class="help-block">'.$errors->first('phone').'</p>':'' !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('country_id')? 'has-error':'' }} hide">
                <label for="phone" class="col-sm-4 control-label">@lang('app.country')</label>
                <div class="col-sm-8">
                    <select id="country_id" name="country_id" class="form-control select2">
                        <option value="">@lang('app.select_a_country')</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ $country->name == 'Tunisia' ? 'selected' :'' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    {!! $errors->has('country_id')? '<p class="help-block">'.$errors->first('country_id').'</p>':'' !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('address')? 'has-error':'' }}">
                <label for="address" class="col-sm-4 control-label">@lang('app.address')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="address"
                           value="{{ old('address')? old('address') : $user->address }}" name="address"
                           placeholder="@lang('app.address')">
                    {!! $errors->has('address')? '<p class="help-block">'.$errors->first('address').'</p>':'' !!}
                </div>
            </div>
            @if(!$user->is_admin())
                <div class="form-group {{ $errors->has('cin')? 'has-error':'' }}">
                    <label for="address" class="col-sm-4 control-label">@lang('app.cin')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="cin"
                               value="{{ old('cin')? old('cin') : $user->cin }}" name="cin"
                               placeholder="@lang('app.cin')">
                        {!! $errors->has('cin')? '<p class="help-block">'.$errors->first('cin').'</p>':'' !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('bank_account_num')? 'has-error':'' }}">
                    <label for="address"
                           class="col-sm-4 control-label">@lang('app.bank_account_num')</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bank_account_num"
                               value="{{ old('bank_account_num')? old('bank_account_num') : $user->bank_account_num }}"
                               name="bank_account_num" placeholder="@lang('app.bank_account_num')">
                        {!! $errors->has('bank_account_num')? '<p class="help-block">'.$errors->first('bank_account_num').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group  {{ $errors->has('company_identity')? 'has-error':'' }}">
                    <label class="col-sm-4 control-label">@lang('app.company_identity')</label>
                    <div class="col-sm-4">
                        <input type="file" id="company_identity" name="company_identity"
                               class="filestyle">
                        {!! $errors->has('company_identity')? '<p class="help-block">'.$errors->first('company_identity').'</p>':'' !!}
                    </div>
                    @if(empty($user->company_identity_validate_status) and $auth_user->is_admin())
                        <div class="col-sm-2">
                            <button type="submit"
                                    class="btn btn-primary pull-right" name="btn-action"
                                    value="validate_company_identity">@lang('app.validate')</button>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit"
                                    class="btn btn-danger pull-right" name="btn-action"
                                    value="reject_company_identity">@lang('app.reject')</button>
                        </div>
                    @else
                        <div class="col-sm-4">
                            @if($user->company_identity_validate_status == \App\User::COMPANY_IDENTITY_VALIDATED )
                                <i class="fa fa-check company-identity-validated fa-2x"></i>
                            @endif
                            @if($user->company_identity_validate_status == \App\User::COMPANY_IDENTITY_REJECTED )
                                <i class="fa fa-remove company-identity-rejected fa-2x"></i>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            <div class="form-group  {{ $errors->has('photo')? 'has-error':'' }}">
                <label class="col-sm-4 control-label">@lang('app.change_avatar')</label>
                <div class="col-sm-8">
                    <input type="file" id="photo" name="photo" class="filestyle">
                    {!! $errors->has('photo')? '<p class="help-block">'.$errors->first('photo').'</p>':'' !!}
                </div>
            </div>

            <hr/>

            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4">
                    <button type="submit" name="btn-action" value="save"
                            class="btn btn-primary">@lang('app.save')</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('page-js')


@endsection