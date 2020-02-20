@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <section class="purchase-funds-container">
            <div class="container">
                <h2 class="text-center">
                    @lang('app.purchase_funds_title')
                </h2>
                <p class="sub-title">
                    @lang('app.purchase_funds_sub_title')
                </p>
            </div>
         {{Form::open([ 'route' => 'add_to_cart', 'class' => 'form-horizontal'])}}
           @if($campaign) <input type="hidden" name="campaign_id" value="{{$campaign->id}}"/>@endif

                <div class="input-group donate_amount_field purchase_funds_amount_field {{ $errors->has('amount')? 'has-error':'' }} col-md-8 col-sm-12" >
                    <input type="number" step="0.001"  name="amount" class="form-control  "
                           value=""
                           placeholder="@lang('app.enter_amount')"/>
                    <div class="input-group-addon currency ">{!! get_currency_symbol(get_option('currency_sign')) !!}</div>

                </div>
                <div class="donate-form-button col-md-4 col-sm-12">
                    <button type="submit" class="btn main-btn main-btn-gradient purchase-fund-btn " @if(!$campaign)disabled="disabled" @endif>@lang('app.buy')</button>
                </div>

            <div style="clear: both">
                {!! $errors->has('amount')? '<p class="help-block has-error">'.$errors->first('amount').'</p>':'' !!}
            </div>
            {{Form::close()}}
            <div class="mask-group"></div>
    </section>
    <section class="categories-wrap"> <!-- explore categories -->
        <div class="">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title"> @lang('app.find_campaign_fund_them')  </h2>
                    </div>
                </div>

                <div class="row">
                    @foreach($categories as $cat)
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="home-category-box">
                                <img src="{{ $cat->get_image_url() }}" />
                                <div class="title">
                                    <a href="{{route('single_category', [$cat->id, $cat->category_slug])}}">{{ $cat->category_name }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


        </div>
    </section> <!-- #explore categories -->

@endsection
