@extends('layouts.tow_column_layout')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')
    @if( ! empty($title))
        <div>
            <h1 class="page-header"> {{ $title }}  </h1>
        </div> <!-- /.row -->
    @endif
    @include('admin.flash_msg')
    <div class="row">
        <div class="col-xs-12">
            {!! Form::open(['class'=>'form-horizontal', 'files'=>'true']) !!}
            <div class="form-group  {{ $errors->has('logo')? 'has-error':'' }}">
                <label class="col-sm-4 control-label">@lang('app.site_logo')</label>
                <div class="col-sm-8">
                    @if(logo_url())
                        <img src="{{ logo_url() }}"/>
                    @endif
                    <input type="file" id="logo" name="logo" class="filestyle">
                    {!! $errors->has('logo')? '<p class="help-block">'.$errors->first('logo').'</p>':'' !!}
                </div>
            </div>

            <hr/>

            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4">
                    <button type="submit" class="btn btn-primary">@lang('app.edit')</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('page-js')


@endsection