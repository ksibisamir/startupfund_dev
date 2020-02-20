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
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if($history_operations->count() > 0)
                        <table class="table table-striped table-bordered" id="investor-history-operations">
                            <thead>
                            <tr>
                                <th>@lang('app.time')</th>
                                <th>@lang('app.campaign')</th>
                                <th>@lang('app.amount')</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($history_operations as $payment)
                                <tr>
                                    <td><span data-toggle="tooltip"
                                              title="{{$payment->created_at->format('d-m-Y H:i')}}">{{$payment->created_at->format('d-m-Y H:i')}}</span>
                                    </td>
                                    <td>
                                        @if( $payment->campaign ) {{$payment->campaign->title}} @endif
                                    </td>
                                    <td>{!! get_amount($payment->amount) !!}</td>
                                    <td>
                                        <a href="{{route('payment_view', $payment->id)}}"><i
                                                    class="fa fa-eye"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div>
                            @lang('app.no_funds_purchased')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
