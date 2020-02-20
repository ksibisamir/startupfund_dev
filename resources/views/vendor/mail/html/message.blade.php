@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
            <link href="{{ asset('assets/css/bootstrap-theme.css') }}" rel="stylesheet">

            <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
            <!-- Google Fonts & Font-Awesome -->
            {{-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400" rel="stylesheet" type="text/css">--}}

            <!-- Font awesome 4.4.0 -->
            <link rel="stylesheet" href="{{ asset('assets/font-awesome-4.7.0/css/font-awesome.min.css') }}">
            <!-- load page specific css -->

            <!-- main select2.css -->
            <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
            <!-- main style.css -->
            <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
            @yield('page-css')
            @if(get_option('additional_css'))
                <style type="text/css">
                    {{ get_option('additional_css') }}
                </style>
            @endif
            <div class="top-navbar">
                <div class="container">
                    <nav class="navbar navbar-default">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <a class="navbar-brand" href="{{ route('home') }}">
                                <img src="{{ asset('assets/images/logo.png') }}" width="240">
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
           Copyright © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
