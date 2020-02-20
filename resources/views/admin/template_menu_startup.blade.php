<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="startup-tab">
        <h5 class="panel-title panel-title-startup">
            <a class="collapsed" data-toggle="collapse" data-parent="#backend-nav" href="#startup-accordion"
               aria-expanded="false" aria-controls="startup-accordion">
                @if(!$auth_user->is_startup_contract_accepted())
                    <a href="/startup-contract">
                        @lang('app.startup_area')
                    </a>
                @else
                    @lang('app.startup_area')
                @endif
            </a>
        </h5>
    </div>
    @if($auth_user->is_startup_contract_accepted())
    <div id="startup-accordion" class="panel-collapse collapse @if($startupCollapse) in @endif" role="tabpanel" aria-labelledby="startup-tab">
        <div class="panel-body">
            <div class="navbar-default sidebar col-sm-12" role="navigation" data-turbolinks-permanent>
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="{{ route('startup_dashboard') }}">
                                <img class="icon" src="{{ asset('assets/images/icons/dashboard-green.svg') }}">
                                <img class="icon active"
                                     src="{{ asset('assets/images/icons/dashboard-white.svg') }}">
                                @lang('app.dashboard')
                            </a>
                        </li>
                        <li><a href="{{route('startup_campaigns')}}">
                                <img class="icon" src="{{ asset('assets/images/icons/compaign-green.svg') }}">
                                <img class="icon active"
                                     src="{{ asset('assets/images/icons/compaign-white.svg') }}">
                                @lang('app.my_campaigns')</a></li>
                        <li><a href="{{route('startup_profile_edit')}}">
                                <img class="icon" src="{{ asset('assets/images/icons/binom-green.svg') }}">
                                <img class="icon active" src="{{ asset('assets/images/icons/binom-white.svg') }}">
                                @lang('app.startup_profile')</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>