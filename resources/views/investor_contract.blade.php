@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')
    <section class="investor-contract-validation">
        <div class="container">
            <a class="print" href="{{ asset('/pdf/STARTUP-FUND-CG-Contributeur-Plateforme.pdf') }}" target="_blank"><i
                        class="fa fa-print"></i> @lang('app.print')</a>
            <form id="register-form" class="form-horizontal" role="form" method="POST" action="{{ route('investor_accept_contract') }}">
                {{ csrf_field() }}
                <div class="sub-container">
                    @lang('contract.investor.content')
                    <div class="checkbox checkbox-inline {{ $errors->has('accept') ? ' has-error' : '' }}">
                        <input type="checkbox" name="accept" id="accept" required>
                        <label for="accept">@lang('app.accept_condition')</label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn validate-button" disabled>
                        @lang('app.validate')
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('page-js')
    <script>
        $(function (){
            $('#accept').click(function(){
                if ($(this).prop('checked')){
                    $('button').removeAttr("disabled");
                    $('button').addClass("main-btn-gradient");
                }else{
                    $('button').attr("disabled","disabled");
                    $('button').removeClass("main-btn-gradient");
                }
            });
        });

    </script>
@endsection