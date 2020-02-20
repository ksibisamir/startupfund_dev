@if(Auth::user() and Auth::user()->is_investor() and !Auth::user()->is_investor_contract_accepted() and  !\Request::is('investor-contract'))
    <script>window.location = "/investor-contract";</script>
@endif
@if(Auth::user() and Auth::user()->is_startup() and !Auth::user()->is_startup_contract_accepted() and  !\Request::is('startup-contract'))
    <script>window.location = "/startup-contract";</script>
@endif
@include('layouts/header')
<div class="page-content">
    <div class="dashboard-wrap">
        <div id="wrapper" class="row equal">

            <div id="menu-wrapper">
                @include('admin.menu')
            </div>

            <div id="page-wrapper" class="col-sm-9">
                <div class="content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts/footer')
