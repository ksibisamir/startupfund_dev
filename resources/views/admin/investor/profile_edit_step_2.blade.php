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
            {!! Form::open(['class'=>'form-horizontal', 'files'=>'true','action' => 'UserController@profileEditStep2Post']) !!}
            @if($auth_user->id != $user->id)
                <input type="hidden"
                       value="{{ old('id')? old('id') : $user->id }}" name="id"
                       required>
            @endif
            <div class="form-group {{ $errors->has('financial_situation_allow_save_portion_income')? 'has-error':'' }}">
                <span class="col-sm-12 control-label font-weight-bold">@lang('app.financial_situation_allow_save_portion_income')</span>
                <div class="col-sm-4">
                    <div class="radio radio-info radio-inline">
                        <input type="radio" id="financial-situation-allow-save-portion-income-yes" value="1"
                               @if($user->financial_situation_allow_save_portion_income == 1) checked
                               @endif name="financial_situation_allow_save_portion_income">
                        <label for="financial-situation-allow-save-portion-income-yes">
                            @lang('app.yes')
                        </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input type="radio" id="financial-situation-allow-save-portion-income-no" value="0"
                               @if($user->financial_situation_allow_save_portion_income == 0) checked
                               @endif name="financial_situation_allow_save_portion_income">
                        <label for="financial-situation-allow-save-portion-income-no">
                            @lang('app.no')
                        </label>
                    </div>
                    {!! $errors->has('financial_situation_allow_save_portion_income')? '<p class="help-block">'.$errors->first('financial_situation_allow_save_portion_income').'</p>':'' !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('amount_wealth')? 'has-error':'' }}">
                <span class="col-sm-12 control-label font-weight-bold">@lang('app.amount_wealth')</span>
                <div class="col-sm-12">
                    <div class="radio radio-info radio-inline">
                        <input id="less_1" type="radio" value="less_1" name="amount_wealth"
                               @if($user->amount_wealth == 'less_1') checked @endif >
                        <label for="less_1">
                            @lang('app.amount_wealth_less_1md')
                        </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input id="between_1_2" type="radio" value="between_1_2" name="amount_wealth"
                               @if($user->amount_wealth == 'between_1_2') checked @endif >
                        <label for="between_1_2">
                            @lang('app.amount_wealth_between_1_2MD')
                        </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input id="more_2" type="radio" value="more_2" name="amount_wealth"
                               @if($user->amount_wealth == 'more_2') checked @endif>
                        <label for="more_2">
                            @lang('app.amount_wealth_more_2MD')
                        </label>
                    </div>
                    {!! $errors->has('amount_wealth')? '<p class="help-block">'.$errors->first('amount_wealth').'</p>':'' !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('financial_products_in_wealth:')? 'has-error':'' }}">
                <span class="col-sm-12 control-label font-weight-bold">@lang('app.financial_products_in_wealth')</span>
                <div class="col-sm-12">
                    <div class="radio radio-info radio-inline">
                        <input id="less_25" type="radio" value="less_25" name="financial_products_in_wealth"
                               @if($user->financial_products_in_wealth == 'less_25') checked @endif>
                        <label for="less_25">
                            @lang('app.financial_products_in_wealth_less_25')
                        </label></div>
                    <div class="radio radio-info radio-inline">
                        <input id="between_25_50" type="radio" value="between_25_50" name="financial_products_in_wealth"
                               @if($user->financial_products_in_wealth == 'between_25_50') checked @endif>
                        <label for="between_25_50">
                            @lang('app.financial_products_in_wealth_between_25_50')
                        </label></div>
                    <div class="radio radio-info radio-inline">
                        <input id="more_50" type="radio" value="more_50" name="financial_products_in_wealth"
                               @if($user->financial_products_in_wealth == 'more_50') checked @endif>
                        <label for="more_50">
                            @lang('app.financial_products_in_wealth_more_50')
                        </label>
                    </div>

                    {!! $errors->has('financial_products_in_wealth')? '<p class="help-block">'.$errors->first('financial_products_in_wealth').'</p>':'' !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('share_unlisted_securities:')? 'has-error':'' }}">
                <span class="col-sm-12 control-label font-weight-bold">@lang('app.share_unlisted_securities')</span>
                <div class="col-sm-12">
                    <div class="radio radio-info radio-inline">
                        <input id="less_5" type="radio" value="less_5" name="share_unlisted_securities"
                               @if($user->share_unlisted_securities == 'less_5') checked @endif>
                        <label for="less_5">
                            @lang('app.share_unlisted_securities_less_5')
                        </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input id="between_5_10" type="radio" value="between_5_10" name="share_unlisted_securities"
                               @if($user->share_unlisted_securities == 'between_5_10') checked @endif>
                        <label for="between_5_10">
                            @lang('app.share_unlisted_securities_between_5_10')
                        </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input id="more_10" type="radio" value="more_10" name="share_unlisted_securities"
                               @if($user->share_unlisted_securities == 'more_10') checked @endif>
                        <label for="more_10">
                            @lang('app.share_unlisted_securities_more_10')
                        </label></div>

                    {!! $errors->has('share_unlisted_securities')? '<p class="help-block">'.$errors->first('financial_products_in_wealth').'</p>':'' !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('origin_entrusted_capital:')? 'has-error':'' }}">
                <span class="col-sm-12 control-label font-weight-bold">@lang('app.origin_entrusted_capital')</span>
                <div class="col-sm-12">
                    <div class="radio radio-info radio-inline">
                        <input id="savings_transformation" type="radio" value="savings_transformation"
                               name="origin_entrusted_capital"
                               @if($user->origin_entrusted_capital == 'savings_transformation' and $user->origin_entrusted_capital_other == '') checked @endif >
                        <label for="savings_transformation">
                            @lang('app.savings_transformation')
                        </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input id="succession_donation" type="radio" value="succession_donation"
                               name="origin_entrusted_capital"
                               @if($user->origin_entrusted_capital == 'succession_donation' and $user->origin_entrusted_capital_other == '') checked @endif >
                        <label for="succession_donation">
                            @lang('app.succession_donation')
                        </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input id="sale_real_estate" type="radio" value="sale_real_estate"
                               name="origin_entrusted_capital"
                               @if($user->origin_entrusted_capital == 'sale_real_estate' and $user->origin_entrusted_capital_other == '') checked @endif>
                        <label for="sale_real_estate">
                            @lang('app.sale_real_estate')
                        </label>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="radio radio-info radio-inline">
                        <input id="sale_financial_products" type="radio" value="sale_financial_products"
                               name="origin_entrusted_capital"
                               @if($user->origin_entrusted_capital == 'sale_financial_products' and $user->origin_entrusted_capital_other == '') checked @endif>
                        <label for="sale_financial_products">
                            @lang('app.sale_financial_products')
                        </label>
                    </div>

                    <div class="radio radio-info radio-inline">
                        <input id="origin_entrusted_capital_other" type="radio" value="origin_entrusted_capital_other"
                               name="origin_entrusted_capital"
                               @if($user->origin_entrusted_capital_other != '') checked @endif>
                        <label for="origin_entrusted_capital_other">
                            @lang('app.other_to_precise')
                        </label>
                        <input type="text" class="form-control" style="display: inline-block; width: auto;"
                               name="origin_entrusted_capital_other" value="{{$user->origin_entrusted_capital_other}}">
                    </div>
                    {!! $errors->has('origin_entrusted_capital')? '<p class="help-block">'.$errors->first('financial_products_in_wealth').'</p>':'' !!}
                </div>
                {!! $errors->has('origin_entrusted_capital')? '<p class="help-block">'.$errors->first('financial_products_in_wealth').'</p>':'' !!}

            </div>
            <hr/>
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4">
                    @if( Request()->id )  <a href="{{route('users_edit_step_1',['id'=>Request()->id])}}" @else  <a
                            href="{{route('investor_profile_edit')}}"
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