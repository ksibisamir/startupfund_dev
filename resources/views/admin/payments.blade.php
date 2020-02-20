@extends('layouts.tow_column_layout')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')
    @if( ! empty($title))
        <div>
            <h1 class="page-header"> {{ $title }} <a class="btn btn-primary pull-right"
                                                     href="{{route('payments_pending')}}">@lang('app.pending_payments')</a>
            </h1>
        </div> <!-- /.row -->
    @endif

    @include('admin.flash_msg')

    <div class="admin-campaign-lists">
        <div class="row">
            <div class="col-md-5">
                @lang('app.total') : {{$payments->count()}}
            </div>

            <div class="col-md-7">

                <form class="form-inline" method="get" action="">
                    <div class="form-group">
                        <input type="text" name="q" value="{{request('q')}}" class="form-control"
                               placeholder="@lang('app.payer_email')">
                    </div>
                    <button type="submit" class="btn btn-default">@lang('app.search')</button>
                </form>
            </div>
        </div>

    </div>

    @if($payments->count() > 0)
        <table class="table table-striped table-bordered">
            <tr>
                <th>Id</th>
                <th>@lang('app.campaign_title')</th>
                <th>@lang('app.payer_email')</th>
                <th>@lang('app.amount')</th>
                <th>@lang('app.method')</th>
                <th>@lang('app.time')</th>
                <th>#</th>
            </tr>
            @foreach($payments as $payment)
                <tr>
                    <td>{{$payment->id}}</td>
                    <td>
                        @if($payment->campaign)
                            <a href="{{route('payment_view', $payment->id)}}">{{$payment->campaign->title}}</a>
                        @else
                            @lang('app.campaign_deleted')
                        @endif
                    </td>
                    <td>
                        <a href="{{route('payment_view', $payment->id)}}"> @if($payment->user) {{$payment->user->email}} @endif </a>
                    </td>
                    <td>{!! get_amount($payment->amount) !!}</td>
                    <td>{{$payment->payment_method}}</td>
                    <td><span data-toggle="tooltip"
                              title="{{$payment->created_at->format('F d, Y h:i a')}}">{{$payment->created_at->format('F d, Y')}}</span>
                    </td>

                    <td>
                        @if($payment->status == 'success')
                            <span class="text-success" data-toggle="tooltip" title="{{$payment->status}}"><i
                                        class="fa fa-check-circle-o"></i> </span>
                        @else
                            <span class="text-warning" data-toggle="tooltip" title="{{$payment->status}}"><i
                                        class="fa fa-exclamation-circle"></i> </span>
                        @endif


                        <a href="{{route('payment_view', $payment->id)}}"><i class="fa fa-eye"></i> </a>

                        @if($payment->tledger_transfer_status == 'done')
                            <span class="text-success" data-toggle="tooltip" title="SUF Transfer Done"><i
                                        class="fa fa-check-circle-o"></i> </span>
                        @elseif($payment->tledger_transfer_status == 'pending')
                            <span class="text-warning" data-toggle="tooltip" title="SUF Transfer Pending"><i
                                        class="fa fa-exclamation-circle"></i> </span>
                        @else
                            <span class="text-danger" data-toggle="tooltip" title="SUF Transfer Failed"><i
                                        class="fa fa-exclamation-triangle"></i> </span>
                        @endif
                    </td>
                </tr>
            @endforeach

        </table>

        {!! $payments->links() !!}

    @else
        @lang('app.no_data')
    @endif
@endsection