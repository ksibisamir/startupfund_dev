@extends('layouts.tow_column_layout')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection

@section('content')
    @if( ! empty($title))
        <div>
            <h1 class="page-header"><span class="border-bottom">{{ $title }} </span></h1>
        </div> <!-- /.row -->
    @endif

    @include('admin.flash_msg')
    {!! Form::open(['class' => 'form-horizontal']) !!}

    <div class="form-group {{ $errors->has('old_password')? 'has-error' : '' }}">
        <label class="col-sm-4 control-label" for="old_password">@lang('app.old_password') *</label>
        <div class="col-sm-8">
            <input type="password" name="old_password" id="old_password" class="form-control" value=""
                   autocomplete="off" placeholder="@lang('app.old_password') "/>
            {!! $errors->has('old_password')? '<p class="help-block"> '.$errors->first('old_password').' </p>':'' !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('new_password')? 'has-error' : '' }}">
        <label class="col-sm-4 control-label" for="new_password">@lang('app.new_password') *</label>
        <div class="col-sm-8">
            <input type="password" name="new_password" id="new_password" class="form-control" value=""
                   autocomplete="off" placeholder="@lang('app.new_password')"/>
            {!! $errors->has('new_password')? '<p class="help-block"> '.$errors->first('new_password').' </p>':'' !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('new_password_confirmation')? 'has-error' : '' }}">
        <label class="col-sm-4 control-label" for="new_password_confirmation">@lang('app.password_confirmation')
            *</label>
        <div class="col-sm-8">
            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                   class="form-control" value="" autocomplete="off"
                   placeholder="@lang('app.password_confirmation')"/>
            {!! $errors->has('new_password_confirmation')? '<p class="help-block"> '.$errors->first('new_password_confirmation').' </p>':'' !!}
        </div>
    </div>

    <div class="form-group action-group">
        <div class="col-md-offset-4 col-md-10">
            <button type="submit" class="btn btn-primary">@lang('app.update')</button>
        </div>
    </div>
    </form>
@endsection

@section('page-js')

@endsection