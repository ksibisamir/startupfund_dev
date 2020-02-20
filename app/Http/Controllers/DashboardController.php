<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Http\Controllers\Auth\TledgerApiController;
use App\Payment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * @var
     */
    public $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function dashboard()
    {

        $user = Auth::user();
        if ($user->is_admin()) {
            $title = trans('app.my_wallet');
            $user_count = User::all()->count();
            $pending_campaign_count = Campaign::pending()->count();
            $blocked_campaign_count = Campaign::blocked()->count();
            $active_campaign_count = Campaign::active()->count();
            $payment_created = Payment::success()->count();
            $payment_amount = Payment::success()->sum('amount');
            $pending_payment_amount = Payment::pending()->sum('amount');
            $my_purchase_funds = false;
            $purchase_funds = false;
            $investment_value = 0;
            $wallet_id = '';

            $pending_campaigns = Campaign::pending()->where('for_purchase_funds', 0)->orderBy('id', 'desc')->take(10)->get();

            $last_payments = Payment::success()
                ->whereHas('campaign', function ($q) {
                    $q->where('for_purchase_funds', '!=', 1);
                })->orderBy('id', 'desc')->take(10)->get();

            $purchase_funds = Payment::whereHas('campaign', function ($q) {
                $q->where('for_purchase_funds', '=', 1);
            })
                ->orderBy('id', 'desc')->get();
            return view('admin.dashboard', compact('title', 'user_count', 'active_campaign_count', 'pending_campaign_count', 'blocked_campaign_count', 'payment_created', 'payment_amount', 'pending_payment_amount', 'pending_campaigns', 'last_payments', 'my_purchase_funds', 'purchase_funds', 'investment_value', 'wallet_id'));


        }
        if ($user->is_investor()) {
            return redirect(route('investor_dashboard'));
        }
        if ($user->is_startup()) {
            return redirect(route('startup_dashboard'));
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function startupDashboard()
    {

        $user = Auth::user();
        $title = trans('app.my_wallet');
        $user_count = User::all()->count();
        $pending_campaign_count = Campaign::pending()->count();
        $blocked_campaign_count = Campaign::blocked()->count();
        $active_campaign_count = Campaign::active()->count();
        $payment_created = Payment::success()->count();
        $payment_amount = Payment::success()->sum('amount');
        $pending_payment_amount = Payment::pending()->sum('amount');
        $purchase_funds = false;
        $wallet_id = '';

        if ($user->tledger_access_token && !empty($user->tledger_access_token)) {
            $tledgerApiController = new TledgerApiController();
            $tledgerUserWallets = $tledgerApiController->getUserWallets($user->tledger_access_token);
            $wallet_id = $tledgerUserWallets['data']['id'];
            $user->tledger_wallet_id = $wallet_id;
            $user->save();
        }
        $campaign_ids = $user->my_campaigns()->pluck('id')->toArray();
        $pending_campaigns = Campaign::pending()->whereUserId($user->id)->orderBy('id', 'desc')->take(10)->get();
        $last_payments = Payment::success()->whereIn('campaign_id', $campaign_ids)->orderBy('id', 'desc')->take(10)->get();
        $my_purchase_funds = Payment::success()->whereUserId($user->id)
            ->whereHas('campaign', function ($q) {
                $q->where('for_purchase_funds', '=', 1);
            })
            ->orderBy('id', 'desc')->get();
        $investment_value = Payment::success()->whereUserId($user->id)->sum('amount');
        return view('admin.startup.dashboard', compact('title', 'user_count', 'active_campaign_count', 'pending_campaign_count', 'blocked_campaign_count', 'payment_created', 'payment_amount', 'pending_payment_amount', 'pending_campaigns', 'last_payments', 'my_purchase_funds', 'purchase_funds', 'investment_value', 'wallet_id'));

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function investorDashboard()
    {

        $user = Auth::user();

        $title = trans('app.my_wallet');
        $user_count = User::all()->count();
        $pending_campaign_count = Campaign::pending()->count();
        $blocked_campaign_count = Campaign::blocked()->count();
        $active_campaign_count = Campaign::active()->count();
        $payment_created = Payment::success()->count();
        $payment_amount = Payment::success()->sum('amount');
        $pending_payment_amount = Payment::pending()->sum('amount');
        $campaign_ids = $user->my_campaigns()->pluck('id')->toArray();
        $pending_campaigns = Campaign::pending()->whereUserId($user->id)->orderBy('id', 'desc')->take(10)->get();
        $last_payments = Payment::success()->whereIn('campaign_id', $campaign_ids)->orderBy('id', 'desc')->take(10)->get();
        $purchase_funds = false;
        $wallet_id = '';
        $suf_balance = 0;
        $my_purchase_funds = Payment::success()->whereUserId($user->id)
            ->whereHas('campaign', function ($q) {
                $q->where('for_purchase_funds', '=', 1);
            })
            ->orderBy('id', 'desc')->get();
        $investment_value = Payment::success()->whereUserId($user->id)->sum('amount');
        if ($user->tledger_access_token && !empty($user->tledger_access_token)) {
            $tledgerApiController = new TledgerApiController();
            if(empty($user->tledger_wallet_id)){
                $tledgerUserWallets = $tledgerApiController->getUserWallets($user->tledger_access_token);
                $wallet_id = $tledgerUserWallets['data']['id'];
                $user->tledger_wallet_id = $wallet_id;
                $user->save();
            }else{
                $wallet_id = $user->tledger_wallet_id;
            }
            $tledgerDashboard = $tledgerApiController->getUserDashboard($user->tledger_access_token);
            $suf_balance = $tledgerDashboard['data']['tokens'][1]['balance'] / 1000;
        }

        return view('admin.investor.dashboard', compact('title', 'user_count', 'active_campaign_count', 'pending_campaign_count', 'blocked_campaign_count', 'payment_created', 'payment_amount', 'pending_payment_amount', 'pending_campaigns', 'last_payments', 'my_purchase_funds', 'purchase_funds', 'investment_value', 'wallet_id', 'suf_balance'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subscription()
    {
        $user = Auth::user();
        $payments = $user->payments()->get();
        $title = trans('app.subscription');
        $campaign = Campaign::where('for_purchase_funds', 1)->first();
        return view('admin.investor.subscription', compact('title', 'campaign','payments','user'));

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function historyOperations()
    {
        $user = Auth::user();
        $title = trans('app.history_of_operations');
        $history_operations = Payment::success()->whereUserId($user->id)->orderBy('id', 'desc')->get();
        /*return view('admin.history_operations', compact('title', 'history_operations'));*/
        return view('admin.under_construction', compact('title', 'history_operations'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function underConstruction()
    {
        return view('admin.under_construction');
    }
}
