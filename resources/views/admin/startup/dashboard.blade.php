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

@endsection