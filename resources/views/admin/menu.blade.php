@php
    $auth_user = \Illuminate\Support\Facades\Auth::user();
    use Illuminate\Support\Str;
@endphp

@if($auth_user->is_admin())
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard "></i> @lang('app.dashboard')</a>
                </li>
                <li>
                    <a href="#"><i
                                class="fa fa-bullhorn "></i> @lang('app.my_campaigns'){{--<span class="fa arrow"></span>--}}
                    </a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{route('my_campaigns')}}">@lang('app.my_campaigns')</a></li>
                        <li>
                            @if(Auth::user()->is_kyc_validate() or Auth::user()->is_admin())
                                <a href="{{route('start_campaign')}}">@lang('app.start_a_campaign')</a>
                            @else
                                <a class="disabled cursor-not-allowed">@lang('app.start_a_campaign')</a>
                            @endif
                        </li>
                        <li><a href="{{route('my_pending_campaigns')}}">@lang('app.pending_campaigns')</a></li>
                    </ul>
                </li>
                {{--                @if($auth_user->is_investor_business_angel())--}}
                {{--                    <li> <a href="{{route('history_operations')}}"><i class="fa fa-history"></i> @lang('app.history_of_operations')</a>  </li>--}}
                {{--                @endif--}}

                <li><a href="{{ route('categories') }}"><i class="fa fa-folder-o "></i> @lang('app.categories')</a></li>
                <li>
                    <a href="#"><i
                                class="fa fa-bullhorn "></i> @lang('app.campaigns'){{--<span class="fa arrow"></span>--}}
                    </a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{ route('all_campaigns') }}">@lang('app.all_campaigns')</a></li>
                        <li><a href="{{ route('staff_picks') }}">@lang('app.staff_picks')</a></li>
                        <li><a href="{{ route('funded') }}">@lang('app.funded')</a></li>
                        <li><a href="{{ route('blocked_campaigns') }}">@lang('app.blocked_campaigns')</a></li>
                        <li><a href="{{ route('pending_campaigns') }}">@lang('app.pending_campaigns')</a></li>
                        <li><a href="{{ route('expired_campaigns') }}">@lang('app.expired_campaigns')</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-wrench "></i> @lang('app.settings')<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{ route('languages.index') }}">@lang('app.translate')</a></li>
                        <li><a href="{{ route('general_settings') }}">@lang('app.general_settings')</a></li>
                        <li><a href="{{ route('payment_settings') }}">@lang('app.payment_settings')</a></li>
                        <li><a href="{{ route('theme_settings') }}">@lang('app.theme_settings')</a></li>
                        <li><a href="{{ route('social_settings') }}">@lang('app.social_settings')</a></li>
                        <li><a href="{{ route('re_captcha_settings') }}">@lang('app.re_captcha_settings')</a></li>
                        <li><a href="{{ route('other_settings') }}">@lang('app.other_settings')</a></li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li><a href="{{ route('pages') }}"><i class="fa fa-file-word-o "></i> @lang('app.pages')</a></li>

                <li><a href="{{route('users')}}"><i class="fa fa-users "></i> @lang('app.users')</a></li>
                <li><a href="{{route('withdrawal_requests')}}"><i
                                class="fa fa-balance-scale "></i> @lang('app.withdrawal_requests')</a></li>


                <li><a href="{{route('payments')}}"><i class="fa fa-money "></i> @lang('app.payments')</a></li>

                {{--            <li> <a href="{{route('withdraw')}}"><i class="fa fa-credit-card"></i> @lang('app.withdraw')</a>  </li>--}}
                <li><a href="{{route('profile_edit')}}"><i class="fa fa-user "></i> @lang('app.profile')</a></li>
                <li><a href="{{route('change_password')}}"><i class="fa fa-lock "></i> @lang('app.change_password')</a>
                </li>

            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
@else
    @php
        $investorCollapse = $startupCollapse = $paramsCollapse = false;
        if (Str::contains(\Route::current()->getName(), "investor")) {
            $investorCollapse = true;
        }
        if (Str::contains(\Route::current()->getName(), "startup")) {
            $startupCollapse = true;
        }
        if($investorCollapse == "" and $startupCollapse == ""){
            $paramsCollapse = true;
        }
    @endphp
    <div id="backend-nav" role="tablist" aria-multiselectable="true">

        @if($investorCollapse == "in")
            @include('admin/template_menu_investor')
            @include('admin/template_menu_startup')
        @endif
        @if($startupCollapse == "in")
            @include('admin/template_menu_startup')
            @include('admin/template_menu_investor')
        @endif
        @if($paramsCollapse == "in")
            @include('admin/template_menu_investor')
            @include('admin/template_menu_startup')
        @endif
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="params-tab">
                <h5 class="panel-title panel-title-params">
                    <a class="collapsed" data-toggle="collapse" data-parent="#backend-nav" href="#params-accordion"
                       aria-expanded="false" aria-controls="params-accordion">
                        <i class="fa fa-cog"></i> @lang('app.settings')
                    </a>
                </h5>
            </div>
            <div id="params-accordion"
                 class="panel-collapse collapse @if(!$startupCollapse and !$investorCollapse)in @endif" role="tabpanel"
                 aria-labelledby="params-tab">
                <div class="panel-body">
                    <div class="navbar-default sidebar col-sm-12" role="navigation" data-turbolinks-permanent>
                        <div class="sidebar-nav navbar-collapse">
                            <ul class="nav" id="side-menu">
                                <li><a href="{{route('change_password')}}">
                                        <img class="icon" src="{{ asset('assets/images/icons/lock-green.svg') }}">
                                        <img class="icon active"
                                             src="{{ asset('assets/images/icons/lock-white.svg') }}">
                                        @lang('app.change_password')</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@section('menu-js')
    <script>
        $(document).ready(function (){
            var contentHeight = $(window).height() - ($(".top-navbar").height());
            $("#page-wrapper > .content").attr('style', 'height:' + contentHeight + 'px !important')
            $("#wrapper").attr('style', 'height:' + contentHeight + 'px !important')

            var heightMenu = contentHeight - ($("#investor-tab").height() + $("#startup-tab").height() + $("#params-tab").height()) - 147;
            $("#investor-accordion .panel-body").attr('style', 'min-height:' + heightMenu + 'px !important')
            $("#startup-accordion .panel-body").attr('style', 'min-height:' + heightMenu + 'px !important')
            $("#params-accordion .panel-body").attr('style', 'min-height:' + heightMenu + 'px !important')
            $("#investor-accordion").on("show.bs.collapse", function (){
                var $elmt1 = $("#startup-accordion").closest('.panel.panel-default');
                var $elmt2 = $("#investor-accordion").closest('.panel.panel-default');
                $elmt1.detach().insertAfter($elmt2)
            })

            $("#startup-accordion").on("show.bs.collapse", function (){
                var $elmt2 = $("#startup-accordion").closest('.panel.panel-default');
                var $elmt1 = $("#investor-accordion").closest('.panel.panel-default');
                $elmt1.detach().insertAfter($elmt2)
            })
            @php
                $tab = "params-tab";
                if (Str::contains(\Route::current()->getName(), "investor")) {
                    $tab = "investor-tab";
                }
                if (Str::contains(\Route::current()->getName(), "startup")) {
                    $tab = "startup-tab";
                }
            @endphp
            $("#{{$tab}}").css('pointer-events', "none");
        });
    </script>
@endsection