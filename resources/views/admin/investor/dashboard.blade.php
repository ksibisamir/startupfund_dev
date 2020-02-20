@extends('layouts.tow_column_layout')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@php
    $auth_user = \Illuminate\Support\Facades\Auth::user();
@endphp

@section('content')
    @if( ! empty($title))
        <div>
            <h1 class="page-header">
                <span class="border-bottom"> {{ $title }}: {{ $wallet_id }}  </span>
            </h1>
        </div>
    @endif
    @include('admin.flash_msg')
    <div>
        <div class="row investment">
            <div class="col-md-12" align="center">
                <div class="block">
                    <div>@lang('app.investment_value_SUF')</div>
                    <div><strong>{{$suf_balance}} SUF</strong> ({{$suf_balance * env('SUF_TO_TND')}} TND)</div>
                </div>
            </div>
        </div>
        <div class="row investment">
            <div class="col-md-4" align="center">
                <div class="block">
                    <div>@lang('app.SUF_allocated')</div>
                    <div><strong>0</strong></div>
                </div>
            </div>
            <div class="col-md-4" align="center">
                <div class="block">
                    <div>@lang('app.SUF_available')</div>
                    <div><strong>{{$suf_balance}}</strong></div>
                </div>
            </div>
            <div class="col-md-4" align="center">
                <div class="block">
                    <div>@lang('app.Number_startups')</div>
                    <div><strong>{{$pending_campaign_count}}</strong></div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h1 class="page-header"><span class="border-bottom">@lang('app.allocation')</span></h1>
    </div>
    <div>
        <table class="table table-bordered for-datatable">
            <thead>
            <tr>
                <th class="asc">@lang('app.name')</th>
                <th class="desc">@lang('app.number_shares_subscribed')</th>
                <th>@lang('app.value_shares_subscribed')</th>
                <th class="no-sortable"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row"><img class="icon" src="{{ asset('assets/images/logo.png') }}"
                                     width="50%"></th>
                <td>{{$suf_balance}}</td>
                <td>{{$suf_balance * env('SUF_TO_TND')}}</td>
                <td><img class="icon" src="{{ asset('assets/images/icons/confirme.svg') }}"
                         width="30px"></td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection