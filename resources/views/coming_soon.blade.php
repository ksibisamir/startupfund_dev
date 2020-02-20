@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')
    <section class="coming-soon-wrap">
    <div class="container">
        <div class="">

                        <h1> @lang('app.coming_soon')</h1>
                        <br>
                        @include('admin.flash_msg')
                        {{Form::open([ 'route' => 'add_coming_soon_mail', 'class' => 'form-horizontal'])}}
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}" >
{{--                            <label class="col-md-4 control-label" for="textinput"></label>--}}
                            <div class="col-md-7" align="left">
                                <input id="email" name="email" type="text" placeholder="@lang('app.email')" class="form-control input-md">
                                <span class="help-block"></span>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-5">
                                <button class="btn btn-primary" style="width: 100%">@lang('app.subscribe')</button>
                            </div>
                        </div>
                        {{Form::close()}}

        </div>
    </div>
</section>

@endsection


@section('page-js')

@endsection

