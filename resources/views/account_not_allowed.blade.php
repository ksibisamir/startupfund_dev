@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <section class="checkout-empty">


        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">


                    <div class="checkout-wrap">
                        <h1><i class="fa fa-exclamation-triangle"></i> @lang('app.account_not_allowed')</h1>
                        <a href="{{route('home')}}" class="btn btn-lg-filled">@lang('app.home')</a>
                    </div>
                </div>

            </div>
        </div>

    </section>


@endsection

