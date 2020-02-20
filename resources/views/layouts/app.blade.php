<?php
if(!isset($_COOKIE['startupfund-allowed-access'])) { ?>
    @include('allow-access')
<?php
}
else
    {
?>
{{--@if(!\Request::is('maintenance') && !\Request::is('register_startup'))--}}
{{--    <script>window.location = "/maintenance";</script>--}}
{{--@endif--}}
@if(Auth::user() and Auth::user()->is_investor() and !Auth::user()->is_investor_contract_accepted() and  !\Request::is('investor-contract'))
    <script>window.location = "/investor-contract";</script>
@endif
@if(Auth::user() and Auth::user()->is_startup() and !Auth::user()->is_startup_contract_accepted() and  !\Request::is('startup-contract'))
    <script>window.location = "/startup-contract";</script>
@endif
@include('layouts/header')
<div class="page-content">
    @yield('content')
</div>
@include('layouts/footer')
<?php
}
?>