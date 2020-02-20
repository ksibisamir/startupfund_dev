@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')
    <section class="campaign-details-wrap campaign-payment-wrap ">
            <div class="header-content">
                <div class="container">
                    <h1 class="single-campaign-title">{{$campaign->title}}</h1>
                    <h4 class="single-campaign-short-description">
                        {{$campaign->short_description}}
                    </h4>
                </div>
        </div>
        <div class="container">
            <div class="panel-background"></div>
            <div class="panel">
                <div class="checkout-wrap">
                @php
                    $user = Auth::user();
                    $updates_count = $campaign->updates->count();
                     $faqs_count = $campaign->faqs->count();
                @endphp
                <!-- Nav tabs -->
                    @if($campaign->for_purchase_funds == 0)
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="col-sm-4 active">
                                <a href="#home" aria-controls="home" role="tab" data-toggle="tab">@lang('app.campaign_home')</a>
                            </li>
                            <li role="presentation" class="col-sm-4">
                                <a href="#updates" aria-controls="updates" role="tab" data-toggle="tab">
                                    @lang('app.updates') @if($updates_count > 0) ({{$updates_count}}) @endif</a>
                            </li>
                            <li role="presentation" class="col-sm-4">
                                <a href="#faqs" aria-controls="faqs" role="tab" data-toggle="tab">
                                    @lang('app.faqs') @if($faqs_count > 0) ({{$faqs_count}}) @endif</a>
                            </li>
                        </ul>
                    @endif
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="contents">
                                <div class="contributing-to">
                                    <p class="contributing-to-name">
                                    @lang('app.you_will_participate_to_project',[ 'campaign_name' => $campaign->title, 'amount'=>get_amount_raw(session('cart.amount')),'currency'=>get_option('currency_sign') ])
                                    {{--                              ///  <strong> @lang('app.you_are_contributing_to') {{$campaign->user->name}}</strong></p>--}}
                                    <p class="choose_payment_method">@lang('app.choose_payment_method')</p>
                                </div>
                                <div class="payment_methods">
                                    <?php
                                    $currency = get_option('currency_sign');
                                    ?>
                                    <div class="row">
                                        @if(get_option('enable_stripe') == 1)
                                            <div class="col-md-3">
                                                <div class="stripe-button-container">
                                                    <script
                                                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                            data-key="{{ get_stripe_key() }}"
                                                            data-amount="{{ get_stripe_amount(session('cart.amount'))}}"
                                                            data-email="{{session('cart.email')}}"
                                                            data-name="{{ get_option('site_name') }}"
                                                            data-description="{{ $campaign->title." Contributing" }}"
                                                            data-currency="{{$currency}}"
                                                            data-image="{{ asset('assets/images/stripe_logo.jpg') }}"
                                                            data-locale="auto">
                                                    </script>
                                                </div>
                                            </div>
                                        @endif

                                        @if(get_option('enable_paypal') == 1)
                                            <div class="col-md-3">
                                                {{ Form::open(['route' => 'payment_paypal_receive']) }}
                                                <input type="hidden" name="cmd" value="_xclick"/>
                                                <input type="hidden" name="no_note" value="1"/>
                                                <input type="hidden" name="lc" value="UK"/>
                                                <input type="hidden" name="currency_code"
                                                       value="{{get_option('currency_sign')}}"/>
                                                <input type="hidden" name="bn"
                                                       value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest"/>
                                                <button type="submit" class="btn btn-info"><i
                                                            class="fa fa-paypal"></i> @lang('app.pay_with_paypal')</button>
                                                {{ Form::close() }}
                                            </div>
                                        @endif


                                        @if(get_option('enable_bank_transfer') == 1)
                                            <div class="col-md-4">
                                                <button class="main-btn main-btn-gradient" id="bankTransferBtn00"
                                                        data-toggle="modal" data-target="#bankTransfer"><i
                                                            class="fa fa-bank"></i>
                                                    <div class="payment_method_name">
                                                        @lang('app.pay_with_bank_bank_transfer')
                                                    </div>
                                                </button>
                                            </div>
                                        @endif

                                        @if(get_option('enable_smt') == 1)
                                            <div class="col-md-4">
                                                {{ Form::open(['route' => 'payment_smt_receive']) }}
                                                <button class="main-btn main-btn-gradient" type="submit" id="smtPaymentBtn"><i
                                                            class="fa fa-credit-card-alt"></i>
                                                    <div class="payment_method_name">
                                                        @lang('app.pay_with_smt')
                                                    </div>
                                                </button>
                                                {{ Form::close() }}
                                            </div>
                                        @endif
                                        @if(get_option('enable_payment_species') == 1)
                                            <div class="col-md-4">
                                                <button class="main-btn main-btn-gradient"
                                                        id="paymentSpeciesBtn">
                                                    <i
                                                            class="fa fa-money"></i>
                                                    <div class="payment_method_name">
                                                        @lang('app.enable_payment_species')
                                                    </div>

                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="updates">
                            <div class="row">
                                <div class="col-md-8 contents">

                                    @if($campaign->updates->count() > 0)
                                        @foreach($campaign->updates as $update)
                                            <div class="post">
                                                <div class="post-header">
                                                    <h2>{{$update->title}}</h2>
                                                    <div class="info"> {{$update->created_at->format('j F Y')}} <i class="fa fa-dot-circle-o"></i>  Public  <i class="fa fa-circle "></i> Posteé par Jan M. le mer. 14 août 2019 </div>
                                                </div>
                                                <div class="post-content">
                                                    {!! safe_output(nl2br($update->description)) !!}
                                                </div>
                                                <div class="post-footer">
                                                    <i class="fa fa-comments"></i> <span>@lang('app.comment ')</span> <i class="fa fa-heart"></i> <span>@lang('app.like') (3)</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="no-data">
                                            <i class="fa fa-bell-o"></i><h1>@lang('app.no_update')</h1>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4 left-colone">
                                    @include('campaign_single_sidebar')
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="faqs">
                            <div class="contents">
                                <h1 class="title">FAQ'S</h1>
                                <div class="panel-group" id="faqs-content">
                                    @if($campaign->faqs->count() > 0)
                                        @foreach($campaign->faqs as $faq)

                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#faqs-content" href="#collapse{{$faq->id}}">
                                                            {{$faq->title}} </a>
                                                    </h4>
                                                </div>
                                                <div id="collapse{{$faq->id}}" class="panel-collapse collapse @if ($loop->first) in @endif">
                                                    <div class="panel-body">{!! safe_output(nl2br($faq->description)) !!}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="no-data">
                                            <i class="fa fa-bell-o"></i><h1>@lang('app.no_faq')</h1>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Tabs -->

                        @if(get_option('enable_payment_species') == 1)
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
                                            <strong>@lang('app.tunis_information_technology_fund')</strong>
                                        </p>
                                        <p class="info"><span class="first">
                                                    @lang('app.bank'): <strong>ATTIJARI BANK</strong><span class="print"> <i
                                                            class="fa fa-print fa-2x"></i></span>
                                                    <br>
                                                    RIB: <strong>1235487695874668554</strong>
                                                    </span></p>
                                        <P>
                                            @lang('app.payment_species_specify_reference',['wallet_id'=>$user->tledger_wallet_id])
                                        </P>
                                    </div>
                                    <div class="modal-footer">
                                        {{ Form::open(['route'=>'cash_payment_submit', 'class' => 'form-horizontal', 'files' => true]) }}
                                        <button type="submit"
                                                class="btn btn-primary">@lang('app.payment_species_btn_confirm')</button>
                                        {{ Form::close() }}

                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(get_option('enable_bank_transfer') == 1)
                        <!-- Modal -->
                            <div class="modal fade" id="bankTransfer" tabindex="-1" role="dialog"
                                 aria-labelledby="bankTransferLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        {{ Form::open(['route'=>'bank_transfer_submit', 'id'=>'bankTransferForm', 'class' => 'form-horizontal', 'files' => true]) }}
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
                                                           placeholder="@lang('app.bank_swift_code')">
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
                                                           placeholder="@lang('app.account_number')">
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
                                                           placeholder="@lang('app.branch_name')">
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
                                                           placeholder="@lang('app.branch_address')">
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
                                                           placeholder="@lang('app.account_name')">
                                                    {!! $errors->has('account_name')? '<p class="help-block">'.$errors->first('account_name').'</p>':'' !!}
                                                </div>
                                            </div>

                                            <div class="form-group {{ $errors->has('iban')? 'has-error':'' }}">
                                                <label for="iban"
                                                       class="col-sm-4 col-md-3 control-label">@lang('app.iban')</label>
                                                <div class="col-sm-8 col-md-9">
                                                    <input type="text" class="form-control" id="iban"
                                                           value="{{ old('iban') }}" name="iban"
                                                           placeholder="@lang('app.iban')">
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
                        @endif
                    </div>
            </div>
        </div>
    </section>
@endsection

@section('page-js')
    <script>
        $(function (){
            $('.stripe-button').on('token', function (e, token){
                $('#stripeForm').replaceWith('');

                $.ajax({
                    url: '{{route('payment_stripe_receive')}}',
                    type: "POST",
                    data: { stripeToken: token.id, _token: '{{ csrf_token() }}' },
                    success: function (data){
                        if (data.success == 1) {
                            $('.checkout-wrap').html(data.response);
                            toastr.success(data.msg, '@lang('app.success')', toastr_options);
                        }
                    }
                });
            });

            @if(get_option('enable_bank_transfer') == 1)

            $('#bankTransferBtn').click(function (){
                $('.paymentSpeciesWrap').hide();
                $('.bankPaymetWrap').slideToggle();
            });

            {{--$('#bankTransferForm').submit(function (e){--}}
            {{--    e.preventDefault();--}}

            {{--    var form_input = $(this).serialize() + '&_token={{csrf_token()}}';--}}

            {{--    $.ajax({--}}
            {{--        url: '{{route('bank_transfer_submit')}}',--}}
            {{--        type: "POST",--}}
            {{--        data: form_input,--}}
            {{--        success: function (data){--}}
            {{--            if (data.success == 1) {--}}
            {{--                $('.checkout-wrap').html(data.response);--}}
            {{--                toastr.success(data.msg, '@lang('app.success')', toastr_options);--}}
            {{--            }--}}
            {{--        },--}}
            {{--        error: function (jqXhr, json, errorThrown){--}}
            {{--            var errors = jqXhr.responseJSON;--}}
            {{--            var errorsHtml = '';--}}
            {{--            $.each(errors, function (key, value){--}}
            {{--                errorsHtml += '<li>' + value[0] + '</li>';--}}
            {{--            });--}}
            {{--            toastr.error(errorsHtml, "Error " + jqXhr.status + ': ' + errorThrown);--}}
            {{--        }--}}
            {{--    });--}}

            {{--});--}}
            @endif

            @if(get_option('enable_payment_species') == 1)
            $('#paymentSpeciesBtn').click(function (){
                $('.panel-background').css('display', 'block');
                $('.mm-modal-dialog').css('display', 'flex');
            });

            $('.mm-modal-dialog .close').click(function (){
                $('.panel-background').css('display', 'none');
                $('.mm-modal-dialog').css('display', 'none');
            });

            $('.panel-background').click(function (){
                $('.panel-background').css('display', 'none');
                $('.mm-modal-dialog').css('display', 'none');
            });
            @endif
        });
    </script>
@endsection