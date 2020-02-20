@extends('layouts.tow_column_layout')

@section('title') @if(! empty($title)) {{$title}} @endif - @parent @endsection
@php
    $auth_user = \Illuminate\Support\Facades\Auth::user();
@endphp

@section('content')
    @if( ! empty($title))
        <div>
            <h1 class="page-header"> {{ $title }}  </h1>
        </div> <!-- /.row -->
    @endif

    @include('admin.flash_msg')

    <div class="row">
            {!! Form::open(['class'=>'form-horizontal', 'files'=>'true','action' => 'UserController@profileEditStep4Post']) !!}
        @if($auth_user->id != $user->id)
            <input type="hidden"
                   value="{{ old('id')? old('id') : $user->id }}" name="id"
                   required>
        @endif
            <div class="form-group {{ $errors->has('objectives_sought')? 'has-error':'' }}">
                <div class="control-label font-weight-bold">@lang('app.objectives_sought')</div>

                <div class="col-sm-12 checkbox checkbox-inline">
                    <input id="tax_reduction" type="checkbox" value="tax_reduction" name="tax_reduction"
                                                              @if( in_array('tax_reduction', $objectives_sought)) checked @endif>
                    <label for="tax_reduction">@lang('app.tax_reduction')</label>
                </div>

                <div class="col-sm-12 checkbox checkbox-inline">
                    <input id="return_on_my_investments" type="checkbox" value="return_on_my_investments" name="return_on_my_investments"
                                                              @if(in_array('return_on_my_investments', $objectives_sought)) checked @endif>
                    <label for="return_on_my_investments">
                         @lang('app.return_on_my_investments')
                    </label>
                </div>

                <div class="col-sm-12 checkbox checkbox-inline">
                    <input id="diversification_of_my_portfolio" type="checkbox" value="diversification_of_my_portfolio" name="diversification_of_my_portfolio"
                           @if(in_array('diversification_of_my_portfolio', $objectives_sought)) checked @endif>
                    <label for="diversification_of_my_portfolio">
                        @lang('app.diversification_of_my_portfolio')
                    </label>
                </div>

                <div class="col-sm-12 checkbox checkbox-inline">
                    <input id="objectives_sought_other" type="checkbox" value="objectives_sought_other" name="objectives_sought_other"
                           @if(in_array('objectives_sought_other', $objectives_sought)) checked @endif>
                    <label for="objectives_sought_other">
                        @lang('app.other_to_precise')
                    </label>
                    <input type="text" class="form-control" style="display: inline-block; width: auto;"
                           value="@if(in_array('objectives_sought_other', $objectives_sought)) {{$user->objectives_sought_other}} @endif" name="objectives_sought_other_input">
                    {!! $errors->has('objectives_sought')? '<p class="help-block">'.$errors->first('objectives_sought').'</p>':'' !!}
                </div>
            </div>

            <hr/>
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4">
                    @if( Request()->id )  <a href="{{route('users_edit_step_3',['id'=>Request()->id])}}" @else  <a
                            href="{{route('investor_profile_edit_step3')}}"
                            @endif class="btn btn-success">@lang('app.previous')</a>
                    <button type="submit" value="save"
                            class="btn btn-primary ">@lang('app.save')</button>
                </div>
            </div>
            {!! Form::close() !!}
    </div>

@endsection

@section('page-js')


@endsection