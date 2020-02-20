@extends('layouts.tow_column_layout')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection


@section('content')

    @if( ! empty($title))
        <div>
            <h1 class="page-header"> {{ $title }}  </h1>
        </div> <!-- /.row -->
    @endif

    @include('admin.flash_msg')

    <div class="row">
        <div class="col-sm-8 col-sm-offset-1 col-xs-12">

            {{ Form::open(['class' => 'form-horizontal', 'files' => true]) }}

            <div class="form-group {{ $errors->has('category_name')? 'has-error':'' }}">
                <label for="category_name" class="col-sm-4 control-label">@lang('app.category_name')</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="category_name" value="{{ $category->category_name }}"
                           name="category_name" placeholder="@lang('app.category_name')">
                    {!! $errors->has('category_name')? '<p class="help-block">'.$errors->first('category_name').'</p>':'' !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('image')? 'has-error':'' }}">
                <label for="image" class="col-sm-4 control-label"></label>
                <div class="col-sm-4">

                    <img src="{{$category->get_image_url()}}" class="img-responsive img-thumbnail"/>

                </div>
            </div>

            <div class="form-group {{ $errors->has('image')? 'has-error':'' }}">
                <label for="image" class="col-sm-4 control-label">@lang('app.image')</label>
                <div class="col-sm-8">


                    <input type="file" name="image" id="image" class="form-control">

                    {!! $errors->has('image')? '<p class="help-block">'.$errors->first('image').'</p>':'' !!}

                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-primary">@lang('app.save_new_category')</button>
                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>
@endsection

@section('page-js')

@endsection