@php
    use Illuminate\Support\Str;
@endphp
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="investor-tab">
        <h5 class="panel-title panel-title-investor">
            <a data-toggle="collapse" data-parent="#backend-nav" href="#investor-accordion" aria-expanded="true"
               aria-controls="investor-accordion">
                @if(!$auth_user->is_investor_contract_accepted())
                    <a href="/investor-contract">
                        @lang('app.investor_area')
                    </a>
                @else
                    @lang('app.investor_area')
                @endif
            </a>
        </h5>
    </div>
    @if($auth_user->is_investor_contract_accepted())
    <div id="investor-accordion" class="panel-collapse collapse @if($investorCollapse) in @endif" role="tabpanel" aria-labelledby="investor-tab">
        <div class="panel-body">
            <div class="navbar-default sidebar col-sm-12" role="navigation" data-turbolinks-permanent>
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="{{ route('investor_dashboard') }}">
                                <img class="icon" src="{{ asset('assets/images/icons/dashboard-blue.svg') }}">
                                <img class="icon active"
                                     src="{{ asset('assets/images/icons/dashboard-white.svg') }}">
                                @lang('app.dashboard')
                            </a>
                        </li>
                        <li><a href="{{route('investor_subscription')}}">
                                <img class="icon" src="{{ asset('assets/images/icons/edit-blue.svg') }}">
                                <img class="icon active" src="{{ asset('assets/images/icons/edit-white.svg') }}">
                                @lang('app.souscription')</a>
                        </li>
                        <li><a href="{{route('investor_allocation')}}">
                                <img class="icon" src="{{ asset('assets/images/icons/biderection-blue.svg') }}">
                                <img class="icon active"
                                     src="{{ asset('assets/images/icons/biderection-white.svg') }}">
                                @lang('app.allocation')</a>
                        </li>
                        <li><a href="{{route('investor_document')}}">
                                <img class="icon" src="{{ asset('assets/images/icons/file-blue.svg') }}">
                                <img class="icon active" src="{{ asset('assets/images/icons/file-white.svg') }}">
                                @lang('app.document')</a>
                        </li>
                        <li>
                            <a href="{{route('investor_profile_edit')}}" class="@if(Str::contains(\Route::current()->getName(), "profile")) active @endif">
                                <img class="icon" src="{{ asset('assets/images/icons/profile-blue.svg') }}">
                                <img class="icon active" src="{{ asset('assets/images/icons/profile-white.svg') }}">
                                KYC</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>