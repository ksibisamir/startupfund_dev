@extends('layouts.tow_column_layout')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@php
    $auth_user = \Illuminate\Support\Facades\Auth::user();
@endphp

@section('content')
    @if( ! empty($title))
        <div>
            <h1 class="page-header"><span class="border-bottom"> {{ $title }}  </span></h1>
        </div> <!-- /.row -->
    @endif

    @include('admin.flash_msg')

    @if($auth_user->is_admin())
        <div class="row">

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{{$pending_campaign_count}}</div>
                                <div>@lang('app.pending_campaigns')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{{$active_campaign_count}}</div>
                                <div>@lang('app.active_campaigns')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{{$blocked_campaign_count}}</div>
                                <div>@lang('app.blocked_campaigns')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{{$payment_created}}</div>
                                <div>@lang('app.payment_created')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{!! get_amount($payment_amount) !!}</div>
                                <div>@lang('app.total_payments')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{{$user_count}}</div>
                                <div>@lang('app.users')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">
                                    @php
                                        $campaign_owner_comission = get_option('campaign_owner_commission');
                                    @endphp
                                    {{get_option('campaign_owner_commission')}}%
                                </div>
                                <div>@lang('app.campaign_owner_will_receive')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{{100 - $campaign_owner_comission}}%</div>
                                <div>@lang('app.platform_owner_will_receive')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">


            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">
                                    @php
                                        $platform_owner_commission = ( (100 - $campaign_owner_comission) * $payment_amount ) / 100;
                                    @endphp

                                    {!! get_amount($platform_owner_commission) !!}
                                </div>
                                <div>@lang('app.platform_owner_commission')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">
                                    {!! get_amount($payment_amount - $platform_owner_commission) !!}
                                </div>
                                <div>@lang('app.campaign_owner_commission')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="huge">{!! get_amount($pending_payment_amount) !!}</div>
                                <div>@lang('app.pending_payment_amount')</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @endif

    <div class="row">
        @if($auth_user->is_investor_business_angel())
            <div class="row">

                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div>@lang('app.investment_value')</div>
                                    <br>
                                    <div class="huge">{{ $investment_value }} {{ get_option('currency_sign') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 pull-right">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div>@lang('app.unique_identifier')</div>
                                    <br>
                                    <div class="huge">{{ $wallet_id }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row store-links">

                <div class="col-md-12">
                    <!-- apple store button -->
                    <a href="#">
                        <img width="200px" src="{{ asset('assets/images/App_Store.png') }}">
                    </a>
                    <!-- android button -->
                    <a href="#">
                        <img width="200px" src="{{ asset('assets/images/google_play.png') }}">
                    </a>

                </div>
            </div>
            {{--                        <div class="col-md-12">--}}
            {{--                            <div class="panel panel-default">--}}
            {{--                                <div class="panel-heading">--}}
            {{--                                    @lang('app.my_purchase_funds')--}}
            {{--                                </div>--}}
            {{--                                <div class="panel-body">--}}
            {{--                                @if($my_purchase_funds->count() > 0)--}}
            {{--                                    <table class="table table-striped table-bordered">--}}
            {{--                                        <tr>--}}
            {{--                                            <th>@lang('app.amount')</th>--}}
            {{--                                            <th>@lang('app.time')</th>--}}
            {{--                                            <th></th>--}}
            {{--                                        </tr>--}}
            {{--                                        @foreach($my_purchase_funds as $payment)--}}
            {{--                                            <tr>--}}
            {{--                                                <td>{!! get_amount($payment->amount) !!}</td>--}}
            {{--                                                <td><span data-toggle="tooltip" title="{{$payment->created_at->format('F d, Y h:i a')}}">{{$payment->created_at->format('F d, Y')}}</span></td>--}}
            {{--                                                <td><a href="{{route('payment_view', $payment->id)}}"><i class="fa fa-eye"></i> </a></td>--}}
            {{--                                            </tr>--}}
            {{--                                        @endforeach--}}
            {{--                                    </table>--}}
            {{--                                @else--}}
            {{--                                    <div>--}}
            {{--                                        @lang('app.no_funds_purchased')--}}
            {{--                                    </div>--}}
            {{--                                @endif--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
        @endif
        @if($auth_user->is_startup())
            {{--                            <div class="col-md-12">--}}

            {{--                                <div class="panel panel-default">--}}
            {{--                                    <div class="panel-heading">--}}
            {{--                                        @lang('app.purchase_funds')--}}
            {{--                                    </div>--}}

            {{--                                    <div class="panel-body">--}}

            {{--                                        @if($purchase_funds and $purchase_funds->count() > 0)--}}
            {{--                                            <table class="table table-striped table-bordered">--}}
            {{--                                                <tr>--}}
            {{--                                                    <th>@lang('app.payer_name')</th>--}}
            {{--                                                    <th>@lang('app.amount')</th>--}}
            {{--                                                    <th>@lang('app.payment_method')</th>--}}
            {{--                                                    <th>@lang('app.time')</th>--}}
            {{--                                                    <th>@lang('app.status')</th>--}}
            {{--                                                    <th>#</th>--}}
            {{--                                                </tr>--}}
            {{--                                                @foreach($purchase_funds as $payment)--}}
            {{--                                                    <tr>--}}
            {{--                                                        <td><a href="{{route('payment_view', $payment->id)}}"> {{$payment->user->name}} {{$payment->user->first_name}} </a></td>--}}
            {{--                                                        <td>{!! get_amount($payment->amount) !!}</td>--}}
            {{--                                                        <td>@lang("app.".$payment->payment_method)</td>--}}
            {{--                                                        <td><span data-toggle="tooltip" title="{{$payment->created_at->format('F d, Y h:i a')}}">{{$payment->created_at->format('F d, Y')}}</span></td>--}}
            {{--                                                        <td>@lang("app.".$payment->status)</td>--}}
            {{--                                                        <td>--}}
            {{--                                                            <a href="{{route('payment_view', $payment->id)}}"><i class="fa fa-eye"></i> </a>--}}
            {{--                                                            @if($payment->status == \App\Payment::PENDING_PAYMENT_STATUS)--}}
            {{--                                                                &nbsp;|&nbsp;<a href="{{route('status_change', [$payment->id, 'success'] )}}" class="text-success"><i title="@lang('app.validate_payment')" class="fa fa-check"></i></a>--}}
            {{--                                                            @endif--}}
            {{--                                                        </td>--}}
            {{--                                                    </tr>--}}
            {{--                                                @endforeach--}}
            {{--                                            </table>--}}
            {{--                                        @else--}}
            {{--                                            @lang('app.no_results_to_display')--}}
            {{--                                        @endif--}}
            {{--                                    </div>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
        @endif
        {{--                        <div class="col-md-12">--}}
        {{--                            <div class="panel panel-default">--}}
        {{--                                <div class="panel-heading">--}}
        {{--                                    @lang('app.last_pending_campaigns')--}}
        {{--                                </div>--}}

        {{--                                @if($pending_campaigns->count() > 0)--}}
        {{--                                    <div class="panel-body">--}}
        {{--                                        <table class="table">--}}
        {{--                                            <tr>--}}
        {{--                                                <th>@lang('app.title')</th>--}}
        {{--                                                <th>@lang('app.by')</th>--}}
        {{--                                            </tr>--}}

        {{--                                            @foreach($pending_campaigns as $pc)--}}
        {{--                                                <tr>--}}
        {{--                                                    <td>{{$pc->title}}</td>--}}
        {{--                                                    <td>{{$pc->user->name}} <br /> {{$pc->user->email}} </td>--}}
        {{--                                                </tr>--}}
        {{--                                            @endforeach--}}
        {{--                                        </table>--}}
        {{--                                    </div>--}}
        {{--                                @endif--}}

        {{--                            </div>--}}

        {{--                        </div>--}}




        {{--                        <div class="col-md-12">--}}

        {{--                            <div class="panel panel-default">--}}
        {{--                                <div class="panel-heading">--}}
        {{--                                    @lang('app.last_ten_payment')--}}
        {{--                                </div>--}}

        {{--                                <div class="panel-body">--}}

        {{--                                    @if($last_payments->count() > 0)--}}
        {{--                                        <table class="table table-striped table-bordered">--}}

        {{--                                            <tr>--}}
        {{--                                                <th>@lang('app.campaign_title')</th>--}}
        {{--                                                <th>@lang('app.payer_name')</th>--}}
        {{--                                                <th>@lang('app.amount')</th>--}}
        {{--                                                <th>@lang('app.time')</th>--}}
        {{--                                                <th>@lang('app.status')</th>--}}
        {{--                                                <th>#</th>--}}
        {{--                                            </tr>--}}

        {{--                                            @foreach($last_payments as $payment)--}}

        {{--                                                <tr>--}}
        {{--                                                    <td>--}}
        {{--                                                        @if($payment->campaign)--}}
        {{--                                                            <a href="{{route('payment_view', $payment->id)}}">{{$payment->campaign->title}}</a>--}}
        {{--                                                        @else--}}
        {{--                                                            @lang('app.campaign_deleted')--}}
        {{--                                                        @endif--}}
        {{--                                                    </td>--}}
        {{--                                                    <td><a href="{{route('payment_view', $payment->id)}}"> {{$payment->user->name}} {{$payment->user->first_name}} </a></td>--}}
        {{--                                                    <td>{!! get_amount($payment->amount) !!}</td>--}}
        {{--                                                    <td><span data-toggle="tooltip" title="{{$payment->created_at->format('F d, Y h:i a')}}">{{$payment->created_at->format('F d, Y')}}</span></td>--}}
        {{--                                                    <td>{{ $payment->status }}</td>--}}
        {{--                                                    <td>--}}
        {{--                                                        <a href="{{route('payment_view', $payment->id)}}"><i class="fa fa-eye"></i> </a>--}}

        {{--                                                    </td>--}}

        {{--                                                </tr>--}}
        {{--                                            @endforeach--}}

        {{--                                        </table>--}}

        {{--                                    @else--}}
        {{--                                        @lang('app.no_campaigns_to_display')--}}
        {{--                                    @endif--}}

        {{--                                </div>--}}

        {{--                            </div>--}}

        {{--                        </div>--}}
    </div>
@endsection