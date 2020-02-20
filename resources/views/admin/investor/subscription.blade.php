@extends('layouts.tow_column_layout')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@php
    $auth_user = \Illuminate\Support\Facades\Auth::user();
@endphp

@section('content')
        @if( ! empty($title))
            <div>
                <h1 class="page-header">
                    <span class="border-bottom"> {{ $title }}  </span>
                </h1>
            </div>
        @endif
        @include('admin.flash_msg')
        <div class="subscription">
            <div class="block ">
                <div class="row">
                    <div class="col-md-6 sub-block" align="center">
                        <p>@lang('app.text_subscription_amount_input_top') </p>

                        <div class="input-group ">
                            <input type="number" id="amount" class="form-control" value="100"
                                   placeholder="Saisir ici votre montant">
                            <div class="input-group-addon">TND</div>
                        </div>
                        <div class="subscription-amount-error"></div>
                    </div>
                    <div class="col-md-6">
                        <button class="payment_methods" id="bankTransferBtn00"
                                data-toggle="modal" data-target="#bankTransfer">
                            <img class="icon"
                                 src="{{ asset('assets/images/icons/bank.svg') }}"><span>@lang('app.pay_with_bank_bank_transfer')</span>
                        </button>

                        {{ Form::open(['route' => 'payment_smt_receive']) }}
                        <input type="hidden" class="amount" name="amount" class="form-control" value="100">
                        <input type="hidden" name="campaign_id" value="{{$campaign->id}}" class="form-control">
                        <button class="payment_methods inverse" type="submit" id="smtPaymentBtn">
                            <img class="icon"
                                 src="{{ asset('assets/images/icons/bank-card.svg') }}"><span>@lang('app.pay_with_smt')</span>
                        </button>
                        {{ Form::close() }}

                        <button class="payment_methods"
                                id="paymentSpeciesBtn">
                            <img class="icon"
                                 src="{{ asset('assets/images/icons/mony.svg') }}"><span>@lang('app.enable_payment_species')</span>
                        </button>
                        <div class=""></div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h1 class="page-header"><span class="border-bottom">@lang('app.history')</span></h1>
        </div>
        <div>
            <table class="table table-bordered for-datatable" id="payments">
                <thead>
                <tr>
                    <th class="no-sortable">@lang('app.date')</th>
                    <th class="no-sortable">@lang('app.amount')</th>
                    <th class="no-sortable">SUF</th>
                    <th class="no-sortable">@lang('app.payment_method')</th>
                    <th class="no-sortable">@lang('app.status')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    @if($payment->payment_method == "smt" && $payment->status=="pending")
                        <?php
                            continue;
                        ?>
                    @endif
                    <tr>
                        <td>{{$payment->created_at->format('d/m/Y')}}</td>
                        <td>{{$payment->amount}} TND</td>
                        <td>{{$payment->amount / env('SUF_TO_TND')}}</td>
                        <td>@lang('app.'.$payment->payment_method)</td>
                        <td>@lang('app.'.$payment->status)</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    <div class="modal fade" id="bankTransfer" tabindex="-1" role="dialog"
         aria-labelledby="bankTransferLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {{ Form::open(['route'=>'bank_transfer_submit', 'id'=>'bankTransferForm', 'class' => 'form-horizontal', 'files' => true]) }}
                <input type="hidden" class="amount" name="amount" class="form-control" value="100">
                <input type="hidden" name="campaign_id" value="{{$campaign->id}}" class="form-control">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="bankTransferLabel">@lang('app.bank_payment_transfer')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" align="left">

                    <div align="center">
                        <p class="sub-title"><strong> @lang('app.campaign_unique_info') #{{$campaign->id}} </strong></p>
                        <p class="message"><strong>@lang('app.make_payement_directly_bank')</strong></p>
                    </div>

                    <div class="jumbotron">
                        <h4></h4>

                        <table class="table">
                            <tr>
                                <th>@lang('app.bank_swift_code')</th>
                                <td>{{get_option('bank_swift_code') }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.account_number')</th>
                                <td>{{get_option('account_number') }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.branch_name')</th>
                                <td>{{get_option('branch_name') }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.branch_address')</th>
                                <td>{{get_option('branch_address') }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.account_name')</th>
                                <td>{{get_option('account_name') }}</td>
                            </tr>
                            <tr>
                                <th>@lang('app.iban')</th>
                                <td>{{get_option('iban') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div id="bankTransferStatus"></div>

                    <div class="form-group {{ $errors->has('bank_swift_code')? 'has-error':'' }}">
                        <label for="bank_swift_code" class="col-sm-4 col-md-3 control-label">
                            @lang('app.bank_swift_code') <span
                                    class="field-required">*</span></label>
                        <div class="col-sm-8 col-md-9">
                            <input type="text" class="form-control" id="bank_swift_code"
                                   value="{{ old('bank_swift_code') }}" name="bank_swift_code"
                                   placeholder="@lang('app.bank_swift_code')" required>
                            {!! $errors->has('bank_swift_code')? '<p class="help-block">'.$errors->first('bank_swift_code').'</p>':'' !!}
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('account_number')? 'has-error':'' }}">
                        <label for="account_number"
                               class="col-sm-4 col-md-3 control-label">@lang('app.account_number') <span
                                    class="field-required">*</span></label>
                        <div class="col-sm-8 col-md-9">
                            <input type="text" class="form-control" id="account_number"
                                   value="{{ old('account_number') }}" name="account_number"
                                   placeholder="@lang('app.account_number')" required>
                            {!! $errors->has('account_number')? '<p class="help-block">'.$errors->first('account_number').'</p>':'' !!}
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('branch_name')? 'has-error':'' }}">
                        <label for="branch_name"
                               class="col-sm-4 col-md-3 control-label">@lang('app.branch_name') <span
                                    class="field-required">*</span></label>
                        <div class="col-sm-8 col-md-9">
                            <input type="text" class="form-control" id="branch_name"
                                   value="{{ old('branch_name') }}" name="branch_name"
                                   placeholder="@lang('app.branch_name')" required>
                            {!! $errors->has('branch_name')? '<p class="help-block">'.$errors->first('branch_name').'</p>':'' !!}
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('branch_address')? 'has-error':'' }}">
                        <label for="branch_address"
                               class="col-sm-4 col-md-3 control-label">@lang('app.branch_address') <span
                                    class="field-required">*</span></label>
                        <div class="col-sm-8 col-md-9">
                            <input type="text" class="form-control" id="branch_address"
                                   value="{{ old('branch_address') }}" name="branch_address"
                                   placeholder="@lang('app.branch_address')" required>
                            {!! $errors->has('branch_address')? '<p class="help-block">'.$errors->first('branch_address').'</p>':'' !!}
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('account_name')? 'has-error':'' }}">
                        <label for="account_name"
                               class="col-sm-4 col-md-3 control-label">@lang('app.account_name') <span
                                    class="field-required">*</span></label>
                        <div class="col-sm-8 col-md-9">
                            <input type="text" class="form-control" id="account_name"
                                   value="{{ old('account_name') }}" name="account_name"
                                   placeholder="@lang('app.account_name')" required>
                            {!! $errors->has('account_name')? '<p class="help-block">'.$errors->first('account_name').'</p>':'' !!}
                        </div>
                    </div>

                    <div class="form-group {{ $errors->has('iban')? 'has-error':'' }}">
                        <label for="iban"
                               class="col-sm-4 col-md-3 control-label">@lang('app.iban')</label>
                        <div class="col-sm-8 col-md-9">
                            <input type="text" class="form-control" id="iban"
                                   value="{{ old('iban') }}" name="iban"
                                   placeholder="@lang('app.iban')" required>
                            {!! $errors->has('iban')? '<p class="help-block">'.$errors->first('iban').'</p>':'' !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">@lang('app.submit_payment')</button>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="panel-background"></div>
    <div class="mm-modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="cashPaymentLabel">@lang('app.enable_payment_species')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang('app.payment_species_transfer in_name_of') <br>
                    <strong>@lang('app.ajyal_capital')</strong>
                </p>
                <p class="info"><span class="first">
                                                    @lang('app.bank'): <strong>ATTIJARI BANK</strong><span class="print"> <i
                                    class="fa fa-print fa-2x"></i></span>
                                                    <br>
                                                    RIB: <strong>{{ get_option('species_account_number') }}</strong>
                                                    </span></p>
                <P class="payment-species-specify-reference">
                    @lang('app.payment_species_specify_reference',['wallet_id'=>$user->tledger_wallet_id])
                </P>
            </div>
            <div class="modal-footer">
                {{ Form::open(['route'=>'cash_payment_submit', 'class' => 'form-horizontal', 'files' => true]) }}
                <input type="hidden" class="amount" name="amount" class="form-control" value="100">
                <input type="hidden" name="campaign_id" value="{{$campaign->id}}" class="form-control">
                <button type="submit"
                        class="btn btn-primary">@lang('app.payment_species_btn_confirm')</button>
                {{ Form::close() }}

            </div>
        </div>
    </div>
@endsection
