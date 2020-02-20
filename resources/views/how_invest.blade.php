@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')

    <section class="categories-wrap"> <!-- explore categories -->
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title">@lang('howinvest.how_invest?')</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="comment-investir">
                        <p class="info-title">
                            @lang('howinvest.invest_online_in_all_transparency_from_100_Dinars')
                        </p>
                        <div align="center" class="row">
                            <div class="col-sm-4 cart">
                                <img class="img-responsive"
                                                            src="{{ asset('assets/images/svg/carte.svg') }}"
                                                            width="60%"/>
                                <h2>@lang('howinvest.by_card')</h2>
                                <p>@lang('howinvest.by_card_message').</p>
                            </div>
                            <div class="col-sm-4 espece">
                                <img class="img-responsive"
                                                              src="{{ asset('assets/images/svg/especes.svg') }}"
                                                              width="60%"/>
                                <h2>@lang('howinvest.cash_payment')</h2>
                                <p>@lang('howinvest.cash_payment_message')</p>
                            </div>
                            <div class="col-sm-4 virement">
                                <img class="img-responsive"
                                     src="{{ asset('assets/images/svg/virement.svg') }}"
                                     width="60%"/>
                                <h2>@lang('howinvest.by_transfer')</h2>
                                <p>@lang('howinvest.by_transfer_message')</p>
                            </div>
                        </div>

                        <div>
                            <h1 class="page-header"><span class="border-bottom">@lang('howinvest.advantages')</span></h1>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 advantages-block-left"><img class="img-responsive"
                                                                             src="{{ asset('assets/images/svg/avantage1.svg') }}"
                                                                             width="75%"/></div>
                            <div class="col-sm-6 advantages-block-right text-block">
                                <div>
                                    <h2>@lang('howinvest.advantages_title1')</h2>
                                    <p>@lang('howinvest.advantages_text1')</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 advantages-block-right"><img class="img-responsive"
                                                                              src="{{ asset('assets/images/svg/avantage2.svg') }}"
                                                                              width="75%"/></div>
                            <div class="col-sm-6 advantages-block-left text-block">
                                <div>
                                    <h2>@lang('howinvest.advantages_title2')</h2>
                                    <p>@lang('howinvest.advantages_text2')</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 advantages-block-left"><img class="img-responsive"
                                                                             src="{{ asset('assets/images/svg/avantage3.svg') }}"
                                                                             width="75%"/></div>
                            <div class="col-sm-6 advantages-block-right text-block">
                                <div>
                                    <h2>@lang('howinvest.advantages_title3')</h2>
                                    <p>@lang('howinvest.advantages_text3')</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 advantages-block-right"><img class="img-responsive"
                                                                              src="{{ asset('assets/images/svg/avantage4.svg') }}"
                                                                              width="75%"/></div>
                            <div class="col-sm-6 advantages-block-left text-block">
                                <div>
                                    <h2>@lang('howinvest.advantages_title4')</h2>
                                    <p>@lang('howinvest.advantages_text4')</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h1 class="page-header" style="margin-bottom: 65px;"><span class="border-bottom">Les etapes d&rsquo;inscriptions </span>
                            </h1>
                        </div>

                        <div style="position: relative">
                            <div class="row">
                                <div class="col-sm-6 advantages-block-right">
                                    <div class="row">
                                        <div class="col-sm-4 img-block-right"><img class="img-responsive"
                                                                                   src="{{ asset('assets/images/svg/inscrption1.svg') }}"/>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="message-block block-right">
                                                <h2>1. @lang('howinvest.step1')</h2>
                                                <p>@lang('howinvest.step1_message')</p>
                                                <div class="arrow-right">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 advantages-block-left">
                                    <div class="row">
                                        <div class="col-sm-4 block-left"><img class="img-responsive"
                                                                              src="{{ asset('assets/images/svg/inscrption2.svg') }}"/>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="message-block">
                                                <h2>2. @lang('howinvest.step2')</h2>
                                                <p>@lang('howinvest.step2_message')</p>
                                                <div class="arrow-left">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 advantages-block-right">
                                    <div class="row">
                                        <div class="col-sm-4 img-block-right"><img class="img-responsive"
                                                                                   src="{{ asset('assets/images/svg/inscrption3.svg') }}"/>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="message-block block-right">
                                                <h2>3. @lang('howinvest.step3')</h2>
                                                <p>@lang('howinvest.step3_message')</p>
                                                <div class="arrow-right">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 advantages-block-left">
                                    <div class="row">
                                        <div class="col-sm-4 block-left"><img class="img-responsive"
                                                                              src="{{ asset('assets/images/svg/inscrption4.svg') }}"/>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="message-block">
                                                <h2>4. @lang('howinvest.step4')</h2>
                                                <p>@lang('howinvest.step4_message')</p>
                                                <div class="arrow-left">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-block">&nbsp;</div>
                        </div>

                        <div class="form-group action-group">
                            <div align="center"><a class="btn btn-primary" href="{{route('investor_subscription')}}">@lang('howinvest.invest')</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- #explore categories -->


@endsection

