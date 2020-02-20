@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')
    <section class="campaign-details-wrap">

        <div class="container">

            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <div class="checkout-wrap">

                        <div class="payment-received">
                            <p>@lang('app.payment_receive_fail')</p>
                            <a href="{{route('browse_categories')}}" class="btn btn-filled">@lang('app.home')</a>
                        </div>

                    </div>

                </div>



            </div>


        </div>

    </section>

@endsection

@section('page-js')


@endsection