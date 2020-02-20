@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection
@section('body-class', 'disclaimer')
@section('content')
    <section class="categories-wrap"> <!-- explore categories -->
        <div class="container">
            <div class="modal-title">@lang("disclaimer.title")</div>
            <div class="modal-body text-justify">@lang("disclaimer.content")</div>
        </div>
    </section> <!-- #explore categories -->
@endsection