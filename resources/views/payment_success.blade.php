@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')
    <section class="campaign-details-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="checkout-wrap">
                        <div class="payment-received">
                            <h1> <i class="fa fa-check-circle-o"></i> @lang('app.payment_thank_you')</h1>
                            <div class="resume">
                                {!! Session::get('payment_success_content') !!}
                            </div>
                            <a href="{{url('/dashboard/investor/')}}" class="btn btn-filled">@lang('app.dashboard')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-js')
@endsection