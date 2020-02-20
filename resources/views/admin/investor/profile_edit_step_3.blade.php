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
            {!! Form::open(['class'=>'form-horizontal', 'files'=>'true','action' => 'UserController@profileEditStep3Post']) !!}
            @if($auth_user->id != $user->id)
                <input type="hidden"
                       value="{{ old('id')? old('id') : $user->id }}" name="id"
                       required>
            @endif
            <div class="form-group {{ $errors->has('financial_instruments')? 'has-error':'' }}">
                <span class="col-sm-12 control-label font-weight-bold">@lang('app.financial_instruments')</span>
                <div class="col-sm-12">
                    <div class="checkbox checkbox-info checkbox-inline">
                        <input id="fcp_actions" type="checkbox" value="fcp_actions" name="fcp_actions"
                               @if(in_array('fcp_actions', $user->financial_instruments)) checked @endif >
                        <label for="fcp_actions">
                            @lang('app.fcp_actions')
                        </label>
                    </div>
                    <div class="checkbox checkbox-info checkbox-inline">
                        <input id="bond_funds" type="checkbox" value="bond_funds" name="bond_funds"
                                                                      @if(in_array('bond_funds',$user->financial_instruments)) checked @endif>
                        <label for="bond_funds">
                             @lang('app.bond_funds')
                        </label>
                    </div>
                    <div class="checkbox checkbox-info checkbox-inline">
                        <input id="capital_investment" type="checkbox" value="capital_investment" name="capital_investment"
                                                                      @if(in_array('capital_investment',$user->financial_instruments)) checked @endif >
                        <label for="capital_investment">
                             @lang('app.capital_investment')
                        </label></div>
                    {!! $errors->has('financial_instruments')? '<p class="help-block">'.$errors->first('financial_instruments').'</p>':'' !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('entrust_portfolio_to_professional')? 'has-error':'' }}">
                <span class="col-sm-8 control-label font-weight-bold">@lang('app.entrust_portfolio_to_professional')</span>
                <div class="col-sm-4">
                    <div class="radio radio-info radio-inline">
                        <input id="entrust_portfolio_to_professional1" type="radio" value="1" name="entrust_portfolio_to_professional"
                                                                      @if($user->entrust_portfolio_to_professional == '1') checked @endif>
                        <label for="entrust_portfolio_to_professional1">
                             @lang('app.yes')
                        </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input id="entrust_portfolio_to_professional0" type="radio" value="0" name="entrust_portfolio_to_professional"
                                                                      @if($user->entrust_portfolio_to_professional == '0') checked @endif>
                        <label for="entrust_portfolio_to_professional0">
                             @lang('app.no')
                        </label>
                    </div>
                    {!! $errors->has('entrust_portfolio_to_professional')? '<p class="help-block">'.$errors->first('entrust_portfolio_to_professional').'</p>':'' !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('intervene_in_management_portfolio')? 'has-error':'' }}">
                <span class="col-sm-6 control-label font-weight-bold">@lang('app.intervene_in_management_portfolio')</span>
                <div class="col-sm-6">
                    <div class="radio radio-info radio-inline">
                        <input id="intervene_in_management_portfolio0" type="radio" value="0" name="intervene_in_management_portfolio"
                                                                      @if($user->intervene_in_management_portfolio == '0') checked @endif >
                        <label for="intervene_in_management_portfolio0">
                             @lang('app.no')
                        </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input id="rarely" type="radio" value="rarely" name="intervene_in_management_portfolio"
                                                                      @if($user->intervene_in_management_portfolio == 'rarely') checked @endif >
                        <label for="rarely">
                             @lang('app.rarely')
                        </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input id="regularly" type="radio" value="regularly" name="intervene_in_management_portfolio"
                                                                      @if($user->intervene_in_management_portfolio == 'regularly') checked @endif >
                        <label for="regularly">
                             @lang('app.regularly')
                        </label>
                    </div>
                    {!! $errors->has('intervene_in_management_portfolio')? '<p class="help-block">'.$errors->first('intervene_in_management_portfolio').'</p>':'' !!}
                </div>
            </div>
            <div class="font-weight-bold">
                @lang('app.classification_of_natural_persons')
            </div>
            <p>
                @lang('app.classification_of_natural_persons_content')
            </p>

            <hr/>

            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4">
                    @if( Request()->id )  <a href="{{route('users_edit_step_2',['id'=>Request()->id])}}" @else  <a
                            href="{{route('investor_profile_edit_step2')}}"
                            @endif class="btn btn-success">@lang('app.previous')</a>
                    <button type="submit" value="save"
                            class="btn btn-primary ">@lang('app.next')</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('page-js')


@endsection