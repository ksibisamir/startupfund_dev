<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Category;
use App\Comment;
use App\Country;
use App\Http\Controllers\Auth\TledgerApiController;
use App\LikedComment;
use App\Notifications\UserParticipationNotification;
use App\Payment;
use App\Reward;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use PDF;
use NumberToWords\NumberToWords;
//use App\Jobs\SendSuccessPaymentEmail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('app.start_a_campaign');
        $categories = Category::all();
        $countries = Country::all();

        return view('admin.start_campaign', compact('title', 'categories', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'category' => 'required',
            'title' => 'required',
            'description' => 'required',
            'short_description' => 'required|max:200',
            'goal' => 'required',
            'end_method' => 'required',
            'country_id' => 'required',
        ];
        $this->validate($request, $rules);

        $user_id = Auth::user()->id;

        $slug = unique_slug($request->title);

        //feature image has been moved to update
        $data = [
            'user_id' => $user_id,
            'for_purchase_funds' => (isset($request->for_purchase_funds)) ? 1 : 0,
            'category_id' => $request->category,
            'title' => $request->title,
            'slug' => $slug,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'campaign_owner_commission' => get_option('campaign_owner_commission'),
            'goal' => $request->goal,
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'recommended_amount' => $request->recommended_amount,
            'amount_prefilled' => $request->amount_prefilled,
            'end_method' => $request->end_method,
            'video' => $request->video,
            'feature_image' => '',
            'status' => 0,
            'country_id' => $request->country_id,
            'address' => $request->address,
            'is_funded' => 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        $create = Campaign::create($data);

        if ($create) {
            return redirect(route('edit_campaign', $create->id))->with('success', trans('app.campaign_created'));
        }
        return back()->with('error', trans('app.something_went_wrong'))->withInput($request->input());
    }


    public function myCampaigns()
    {
        $title = trans('app.my_campaigns');
        $user = request()->user();
        //$my_campaigns = $user->my_campaigns;
        $my_campaigns = Campaign::whereUserId($user->id)->orderBy('id', 'desc')->get();

        return view('admin.my_campaigns', compact('title', 'my_campaigns'));
    }

    public function myPendingCampaigns()
    {
        $title = trans('app.pending_campaigns');
        $user = request()->user();
        $my_campaigns = Campaign::pending()->whereUserId($user->id)->orderBy('id', 'desc')->get();

        return view('admin.my_campaigns', compact('title', 'my_campaigns'));
    }


    public function allCampaigns()
    {
        $title = trans('app.all_campaigns');
        $campaigns = Campaign::active()->orderBy('id', 'desc')->paginate(20);
        return view('admin.all_campaigns', compact('title', 'campaigns'));
    }

    public function staffPicksCampaigns()
    {
        $title = trans('app.staff_picks');
        $campaigns = Campaign::staff_picks()->orderBy('id', 'desc')->paginate(20);
        return view('admin.all_campaigns', compact('title', 'campaigns'));
    }

    public function fundedCampaigns()
    {
        $title = trans('app.funded');
        $campaigns = Campaign::funded()->orderBy('id', 'desc')->paginate(20);
        return view('admin.all_campaigns', compact('title', 'campaigns'));
    }


    public function blockedCampaigns()
    {
        $title = trans('app.blocked_campaigns');
        $campaigns = Campaign::blocked()->orderBy('id', 'desc')->paginate(20);
        return view('admin.all_campaigns', compact('title', 'campaigns'));
    }

    public function pendingCampaigns()
    {
        $title = trans('app.pending_campaigns');
        $campaigns = Campaign::pending()->orderBy('id', 'desc')->paginate(20);
        return view('admin.all_campaigns', compact('title', 'campaigns'));
    }

    public function expiredCampaigns()
    {
        $title = trans('app.expired_campaigns');
        $campaigns = Campaign::active()->expired()->orderBy('id', 'desc')->paginate(20);
        return view('admin.all_campaigns', compact('title', 'campaigns'));
    }


    public function searchAdminCampaigns(Request $request)
    {
        $title = trans('app.campaigns_search_results');
        $campaigns = Campaign::where('title', 'like', "%{$request->q}%")->orderBy('id', 'desc')->paginate(20);
        return view('admin.all_campaigns', compact('title', 'campaigns'));
    }

    public function deleteCampaigns($id = 0)
    {
        if (config('app.is_demo')) {
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }

        if ($id) {
            $campaign = Campaign::find($id);
            if ($campaign) {
                $campaign->delete();
            }
        }
        return back()->with('success', trans('app.campaign_deleted'));
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug = null)
    {
        $campaign = Campaign::find($id);
        $title = $campaign->title;
        $teams = Team::where("user_id",$campaign->user->id)->get();

        $enable_discuss = get_option('enable_disqus_comment');
        return view('campaign_single', compact('campaign', 'title', 'enable_discuss','teams'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id = request()->user()->id;
        $campaign = Campaign::find($id);
        //todo: checked if admin then he can access...
        if ($campaign->user_id != $user_id and !Auth::user()->is_admin()) {
            exit('Unauthorized access');
        }

        $title = trans('app.edit_campaign');
        $categories = Category::all();
        $countries = Country::all();

        return view('admin.edit_campaign', compact('title', 'categories', 'countries', 'campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'category' => 'required',
            'title' => 'required',
            'short_description' => 'required|max:200',
            'description' => 'required',
            'goal' => 'required',
            'country_id' => 'required',
        ];

        $this->validate($request, $rules);

        $campaign = Campaign::find($id);

        $image_name = $campaign->feature_image;
        if ($request->hasFile('feature_image')) {

            $image = $request->file('feature_image');

            $valid_extensions = ['jpg', 'jpeg', 'png'];
            if (!in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions)) {
                return redirect()->back()->withInput($request->input())->with('error', 'Only .jpg, .jpeg and .png is allowed extension');
            }

            $upload_dir = './uploads/images/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $thumb_dir = './uploads/images/thumb/';
            if (!file_exists($thumb_dir)) {
                mkdir($thumb_dir, 0777, true);
            }

            //Delete old image
            if ($image_name) {
                if (file_exists($upload_dir . $image_name)) {
                    unlink($upload_dir . $image_name);
                }
                if (file_exists($thumb_dir . $image_name)) {
                    unlink($thumb_dir . $image_name);
                }
            }

            $file_base_name = str_replace('.' . $image->getClientOriginalExtension(), '', $image->getClientOriginalName());
            $full_image = Image::make($image)->orientate()->resize(1500, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $resized = Image::make($image)->orientate()->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image_name = strtolower(time() . str_random(5) . '-' . str_slug($file_base_name)) . '.' . $image->getClientOriginalExtension();

            $thumbFileName = $thumb_dir . $image_name;
            $imageFileName = $upload_dir . $image_name;

            try {
                //Uploading original image
                $full_image->save($imageFileName);
                //Uploading thumb
                $resized->save($thumbFileName);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        $data = [
            'category_id' => $request->category,
            'for_purchase_funds' => (isset($request->for_purchase_funds)) ? 1 : 0,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'goal' => $request->goal,
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'recommended_amount' => $request->recommended_amount,
            'amount_prefilled' => $request->amount_prefilled,
            'end_method' => $request->end_method,
            'video' => $request->video,
            'feature_image' => $image_name,
            'country_id' => $request->country_id,
            'address' => $request->address,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];
        $update = Campaign::whereId($id)->update($data);

        if ($update) {
            return redirect(route('edit_campaign', $id))->with('success', trans('app.campaign_created'));
        }
        return back()->with('error', trans('app.something_went_wrong'))->withInput($request->input());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showBackers($id)
    {
        $campaign = Campaign::find($id);
        $title = trans('app.backers') . ' | ' . $campaign->title;
        return view('campaign_backers', compact('campaign', 'title'));

    }

    public function showUpdates($id)
    {
        $campaign = Campaign::find($id);
        $title = $campaign->title;
        return view('campaign_update', compact('campaign', 'title'));
    }

    public function showFaqs($id)
    {
        $campaign = Campaign::find($id);
        $title = $campaign->title;
        return view('campaign_faqs', compact('campaign', 'title'));
    }

    /**
     * @param $id
     * @return mixed
     *
     * todo: need to be moved it to reward controller
     */
    public function rewardsInCampaignEdit($id)
    {
        $title = trans('app.campaign_rewards');
        $campaign = Campaign::find($id);
        $rewards = Reward::whereCampaignId($campaign->id)->get();
        return view('admin.campaign_rewards', compact('title', 'campaign', 'rewards'));
    }

    /**
     * @param Request $request
     * @param int $reward_id
     * @return mixed
     */
    public function addToCart(Request $request, $reward_id = 0)
    {
        $amount = $request->input('amount');
        if($amount < 100 ){
            Session::flash('amount_error',  trans('app.amount_min_100'));
            return Redirect::back();

            return back()->with('error',  trans('app.amount_min_100'));
        }
        if(!is_int($amount / 100) ){
            Session::flash('amount_error',  trans('app.not_multiplier_100'));
            return Redirect::back();
            return back()->with('error',  trans('app.not_multiplier_100'));
        }
        $rules = [
            'amount' => 'required|numeric|min:100',
        ];

        $this->validate($request, $rules);


        if ($reward_id) {
            //If checkout request come from reward
            session(['cart' => ['cart_type' => 'reward', 'reward_id' => $reward_id]]);

            $reward = Reward::find($reward_id);
            if ($reward->campaign->is_ended()) {
                $request->session()->forget('cart');
                return redirect()->back()->with('error', trans('app.invalid_request'));
            }
        } else {
            //Or if comes from donate button
            session(['cart' => ['cart_type' => 'donation', 'campaign_id' => $request->campaign_id, 'amount' => $request->amount]]);
        }
        if (Auth::guest()) {
            return redirect(route('login'));
        }
        return $this->checkoutPost($request);
//        return redirect(route('checkout'));
    }


    /**
     * @param Request $request
     * @param int $comment_id
     * @return mixed
     */
    public function likeComment(Request $request, $comment_id)
    {

        if (Auth::guest()) {
            return array('error' => true);
        }

        $liked = LikedComment::where('comment_id', $comment_id)->where('user_id', Auth::user()->id)->first();


        if ($liked) {
            $liked->delete();
            $return = array('success' => true, 'result' => 2);
        } else {
            $liked = new LikedComment();
            $liked->user_id = Auth::user()->id;
            $liked->comment_id = $comment_id;
            $liked->save();
            $return = array('success' => true, 'result' => 1);
        }
        $allLikes = LikedComment::where('comment_id', $comment_id)->get();
        $return['nbre'] = $allLikes->count();
        return $return;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function addComment(Request $request)
    {
        $rules = [
            'comment' => 'required',
        ];
        $this->validate($request, $rules);

        if (Auth::guest()) {
            return redirect(route('login'));
        }

        $user_id = Auth::user()->id;
        $campaign_id = $request->campaign;
        //feature image has been moved to update
        $data = [
            'user_id' => $user_id,
            'campaign_id' => $campaign_id,
            'comment' => $request->comment,
            'title' => $request->title ? $request->title : "",
            'status' => 1
        ];
        $create = Comment::create($data);
        if ($create) {
            return back()->with('success', trans('app.comment_saved_msg'));;
        }
        return back()->with('error', trans('app.something_went_wrong'))->withInput($request->input());
    }

    /**
     * @param Request $request
     * @param int $reward_id
     * @return mixed
     */
    public function purchase_funds(Request $request, $reward_id = 0)
    {

        if (Auth::guest()) {
            return redirect(route('login'));
        }

        $rules = [
            'amount' => 'required|numeric|min:100',
        ];

        $this->validate($request, $rules);

        session(['cart' => ['cart_type' => 'puchase_funds', 'campaign_id' => $request->campaign_id, 'amount' => $request->amount]]);
        return $this->checkoutPost($request);
//        return redirect(route('checkout'));
    }

    public function statusChange($id, $status = null)
    {

        $campaign = Campaign::find($id);
        if ($campaign && $status) {

            if ($status == 'approve') {
                $campaign->status = 1;
                $campaign->save();

            } elseif ($status == 'block') {
                $campaign->status = 2;
                $campaign->save();
            } elseif ($status == 'funded') {
                $campaign->is_funded = 1;
                $campaign->save();
            } elseif ($status == 'add_staff_picks') {
                $campaign->is_staff_picks = 1;
                $campaign->save();

            } elseif ($status == 'remove_staff_picks') {
                $campaign->is_staff_picks = 0;
                $campaign->save();
            }

        }
        return back()->with('success', trans('app.status_updated'));
    }

    /**
     * @return mixed
     *
     * Checkout page
     */
    public function checkout(Request $request)
    {

        if (Auth::user()->is_investor_business_angel()) {
            $title = trans('app.checkout');
            if (!session('cart')) {
                return view('checkout_empty', compact('title'));
            }

            $reward = null;
            if (session('cart.cart_type') == 'reward') {
                $reward = Reward::find(session('cart.reward_id'));
                $campaign = Campaign::find($reward->campaign_id);
            } elseif (session('cart.cart_type') == 'donation') {
                $campaign = Campaign::find(session('cart.campaign_id'));
            }
            if (session('cart')) {
                return $this->checkoutPost($request);

//                return view('checkout', compact('title', 'campaign', 'reward'));
            }
            return view('checkout_empty', compact('title'));
        } else {

            $title = trans('app.checkout');
            return view('account_not_allowed', compact('title'));
        }
    }

    public function checkoutPost(Request $request)
    {
        $title = trans('app.checkout');
        if (!session('cart')) {
            return view('checkout_empty', compact('title'));
        }

        $cart = session('cart');
        $input = array_except($request->input(), '_token');
        session(['cart' => array_merge($cart, $input)]);

        if (session('cart.cart_type') == 'reward') {
            $reward = Reward::find(session('cart.reward_id'));
            $campaign = Campaign::find($reward->campaign_id);
        } elseif (session('cart.cart_type') == 'donation') {
            $campaign = Campaign::find(session('cart.campaign_id'));
        }

        //dd(session('cart'));
        return view('payment', compact('title', 'campaign'));
    }

    /**
     * @param Request $request
     * @return mixed
     *
     * Payment gateway PayPal
     */
    public function paypalRedirect(Request $request)
    {
        if (!session('cart')) {
            return view('checkout_empty', compact('title'));
        }
        //Find the campaign
        $cart = session('cart');

        $amount = 0;
        if (session('cart.cart_type') == 'reward') {
            $reward = Reward::find(session('cart.reward_id'));
            $amount = $reward->amount;
            $campaign = Campaign::find($reward->campaign_id);
        } elseif (session('cart.cart_type') == 'donation') {
            $campaign = Campaign::find(session('cart.campaign_id'));
            $amount = $cart['amount'];
        }
        $currency = get_option('currency_sign');
        $user_id = null;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }
        //Create payment in database


        $transaction_id = 'tran_' . time() . str_random(6);
        // get unique recharge transaction id
        while ((Payment::whereLocalTransactionId($transaction_id)->count()) > 0) {
            $transaction_id = 'reid' . time() . str_random(5);
        }
        $transaction_id = strtoupper($transaction_id);

        $payments_data = [
            'name' => session('cart.full_name'),
            'email' => session('cart.email'),

            'user_id' => $user_id,
            'campaign_id' => $campaign->id,
            'reward_id' => session('cart.reward_id'),

            'amount' => $amount,
            'payment_method' => 'paypal',
            'status' => 'initial',
            'currency' => $currency,
            'local_transaction_id' => $transaction_id,

            'contributor_name_display' => session('cart.contributor_name_display'),
        ];
        //Create payment and clear it from session
        $created_payment = Payment::create($payments_data);
        $request->session()->forget('cart');

        // PayPal settings
        $paypal_action_url = "https://www.paypal.com/cgi-bin/webscr";
        if (get_option('enable_paypal_sandbox') == 1)
            $paypal_action_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";

        $paypal_email = get_option('paypal_receiver_email');
        $return_url = route('payment_success', $transaction_id);
        $cancel_url = route('checkout');
        $notify_url = route('paypal_notify', $transaction_id);

        $item_name = $campaign->title . " [Contributing]";

        // Check if paypal request or response
        $querystring = '';

        // Firstly Append paypal account to querystring
        $querystring .= "?business=" . urlencode($paypal_email) . "&";

        // Append amount& currency (£) to quersytring so it cannot be edited in html
        //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
        $querystring .= "item_name=" . urlencode($item_name) . "&";
        $querystring .= "amount=" . urlencode($amount) . "&";
        $querystring .= "currency_code=" . urlencode($currency) . "&";

        $querystring .= "first_name=" . urlencode(session('cart.full_name')) . "&";
        //$querystring .= "last_name=".urlencode($ad->user->last_name)."&";
        $querystring .= "payer_email=" . urlencode(session('cart.email')) . "&";
        $querystring .= "item_number=" . urlencode($created_payment->local_transaction_id) . "&";

        //loop for posted values and append to querystring
        foreach (array_except($request->input(), '_token') as $key => $value) {
            $value = urlencode(stripslashes($value));
            $querystring .= "$key=$value&";
        }

        // Append paypal return addresses
        $querystring .= "return=" . urlencode(stripslashes($return_url)) . "&";
        $querystring .= "cancel_return=" . urlencode(stripslashes($cancel_url)) . "&";
        $querystring .= "notify_url=" . urlencode($notify_url);

        // Append querystring with custom field
        //$querystring .= "&custom=".USERID;

        // Redirect to paypal IPN
        header('location:' . $paypal_action_url . $querystring);
        exit();
    }

    /**
     * @param Request $request
     * @param $transaction_id
     *
     * Check paypal notify
     */
    public function paypalNotify(Request $request, $transaction_id)
    {
        //todo: need to  be check
        $payment = Payment::whereLocalTransactionId($transaction_id)->where('status', '!=', 'success')->first();

        $verified = paypal_ipn_verify();
        if ($verified) {
            //Payment success, we are ready approve your payment
            $payment->status = 'success';
            $payment->charge_id_or_token = $request->txn_id;
            $payment->description = $request->item_name;
            $payment->payer_email = $request->payer_email;
            $payment->payment_created = strtotime($request->payment_date);
            $payment->save();

            //Update totals
            $payment->campaign->updateTotalNow();
        } else {
            $payment->status = 'declined';
            $payment->description = trans('app.payment_declined_msg');
            $payment->save();
        }
        // Reply with an empty 200 response to indicate to paypal the IPN was received correctly
        header("HTTP/1.1 200 OK");
    }

    /***
     * @param Request $request
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function smtRedirect(Request $request)
    {

        if ($request->has('amount')) {
            session(['cart' => ['cart_type' => 'donation', 'campaign_id' => $request->campaign_id, 'amount' => $request->amount]]);
        }
        if (!session('cart')) {
            return view('checkout_empty', compact('title'));
        }
        try {
            //Find the campaign
            $cart = session('cart');
            $amount = 0;
            if (session('cart.cart_type') == 'reward') {
                $reward = Reward::find(session('cart.reward_id'));
                $amount = $reward->amount;
                $campaign = Campaign::find($reward->campaign_id);
            } elseif (session('cart.cart_type') == 'donation') {
                $campaign = Campaign::find(session('cart.campaign_id'));
                $amount = $cart['amount'] ;
            }
            if($amount < 100 ){
                return back()->with('error',  trans('app.amount_min_100'));
            }
            if(!is_int($amount / 100) ){
                return back()->with('error',  trans('app.not_multiplier_100'));
            }
            $smtAmount = $amount * 1000;

            $transaction_id = 'tran_' . time() . str_random(6);
            $currency = get_option('currency_sign');
            $user_id = null;
            if (Auth::check()) {
                $user_id = Auth::user()->id;
            }

            $transaction_id = 'tran_' . time() . str_random(6);
            // get unique recharge transaction id
            while ((Payment::whereLocalTransactionId($transaction_id)->count()) > 0) {
                $transaction_id = 'reid' . time() . str_random(5);
            }
            $transaction_id = strtoupper($transaction_id);
            $request->session()->forget('cart');
            $url = get_option('smt_host') . "/register.do";
            $returnUrl = url('/') . '/checkout/smt-success';
            $failUrl = url('/') . '/checkout/smt-fail';
            $response = file_get_contents($url . '?amount=' . $smtAmount . '&currency=' . get_option('smt_currency') . '&language=fr&orderNumber=' . $transaction_id . '&returnUrl=' . $returnUrl . '&failUrl=' . $failUrl . '&pageView=DESKTOP&password=' . get_option('smt_password') . '&userName=' . get_option('smt_username'));
            $response = json_decode($response);
            if (array_key_exists('errorCode', $response)) {
                return back()->with('error', $response->errorMessage);
            }
            $payments_data = [
                'name' => Auth::user()->name . " " . Auth::user()->first_name,
                'email' => Auth::user()->email,
                'user_id' => $user_id,
                'campaign_id' => $campaign->id,
                'reward_id' => session('cart.reward_id'),
                'amount' => $amount,
                'payment_method' => 'smt',
                'status' => 'pending',
                'currency' => $currency,
                'local_transaction_id' => $transaction_id,
                'smt_order_id' => $response->orderId,
                'contributor_name_display' => session('cart.contributor_name_display'),
            ];
            //Create payment and clear it from session
            $created_payment = Payment::create($payments_data);
            header('location:' . $response->formUrl);
            exit();
        } catch (Exception $e) {
            echo $e->getMessage();die;
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param null $transaction_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function smtPaymentSuccess(Request $request)
    {
        $payment = false;
        if (Input::get('orderId')) {
            $payment = Payment::whereSmtOrderId(Input::get('orderId'))->whereStatus('pending')->first();
            if ($payment) {
                $payment->status = 'success';
                $payment->save();
            }
        }
        return $this->paymentSuccess($payment,'bankCard');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function smtPaymentFail(Request $request)
    {
        if (Input::get('orderId')) {
            $payment = Payment::whereSmtOrderId(Input::get('orderId'))->whereStatus('pending')->first();
            if ($payment) {
                Log:debug("Paiement Smt echoué id: ".$payment->id);
                $payment->status = 'failed';
                $payment->save();
            }
        }
        $title = trans('app.payment_fail');
        return view('payment_fail', compact('title'));
    }


    /**
     * @return string
     */
    public function payment_success_html()
    {
        $html = ' <div class="payment-received">
                            <h1> <i class="fa fa-check-circle-o"></i> ' . trans('app.payment_thank_you') . '</h1>
                            <p>' . trans('app.payment_receive_successfully') . '</p>
                            <a href="' . route('dashboard') . '" class="btn btn-filled">' . trans('app.dashboard') . '</a><script>$(".modal-backdrop").remove()</script>
                        </div>';
        return $html;
    }


    /**
     * @date April 29, 2017
     * @since v.1.1
     */
    public function paymentBankTransferReceive(Request $request)
    {
        $rules = [
            'bank_swift_code' => 'required',
            'account_number' => 'required',
            'branch_name' => 'required',
            'branch_address' => 'required',
            'account_name' => 'required',
        ];
        $this->validate($request, $rules);

        if ($request->has('amount')) {
            session(['cart' => ['cart_type' => 'donation', 'campaign_id' => $request->campaign_id, 'amount' => $request->amount]]);
        }
        if (!session('cart')) {
            return view('checkout_empty', compact('title'));
        }
        //Find the campaign
        $cart = session('cart');

        $amount = 0;
        if (session('cart.cart_type') == 'reward') {
            $reward = Reward::find(session('cart.reward_id'));
            $amount = $reward->amount;
            $campaign = Campaign::find($reward->campaign_id);
        } elseif (session('cart.cart_type') == 'donation') {
            $campaign = Campaign::find(session('cart.campaign_id'));
            $amount = $cart['amount'];
        }

        if($amount < 100 ){
            return back()->with('error',  trans('app.amount_min_100'));
        }
        if(!is_int($amount / 100) ){
            return back()->with('error',  trans('app.not_multiplier_100'));
        }
        $currency = get_option('currency_sign');
        $user_id = null;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }
        //Create payment in database


        $transaction_id = 'tran_' . time() . str_random(6);
        // get unique recharge transaction id
        while (($payment = Payment::whereLocalTransactionId($transaction_id)->count()) > 0) {
            $transaction_id = 'reid' . time() . str_random(5);
        }
        $transaction_id = strtoupper($transaction_id);

        $payments_data = [
            'name' => session('cart.full_name'),
            'email' => session('cart.email'),

            'user_id' => $user_id,
            'campaign_id' => $campaign->id,
            'reward_id' => session('cart.reward_id'),

            'amount' => $amount,
            'payment_method' => 'bank_transfer',
            'status' => 'pending',
            'currency' => $currency,
            'local_transaction_id' => $transaction_id,

            'contributor_name_display' => session('cart.contributor_name_display'),

            'bank_swift_code' => $request->bank_swift_code,
            'account_number' => $request->account_number,
            'branch_name' => $request->branch_name,
            'branch_address' => $request->branch_address,
            'account_name' => $request->account_name,
            'iban' => $request->iban,
        ];
        //Create payment and clear it from session
        $newPayment = Payment::create($payments_data);
        $request->session()->forget('cart');
        return $this->paymentSuccess($newPayment,'bankTransfer');

    }


    /**
     * @date April 29, 2017
     * @since v.1.1
     */
    public function paymentCashReceive(Request $request)
    {
        //get Cart Item
        if ($request->has('amount')) {
            session(['cart' => ['cart_type' => 'donation', 'campaign_id' => $request->campaign_id, 'amount' => $request->amount]]);
        }
        if (!session('cart')) {
            return view('checkout_empty', compact('title'));
        }
        //Find the campaign
        $cart = session('cart');

        $campaign = Campaign::find(session('cart.campaign_id'));
        $amount = $cart['amount'];
        if($amount < 100 ){
            return back()->with('error',  trans('app.amount_min_100'));
        }
        if(!is_int($amount / 100) ){
            return back()->with('error',  trans('app.not_multiplier_100'));
        }
        $currency = get_option('currency_sign');
        $user_id = null;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }
        //Create payment in database

        $transaction_id = 'tran_' . time() . str_random(6);
        // get unique recharge transaction id
        while ((Payment::whereLocalTransactionId($transaction_id)->count()) > 0) {
            $transaction_id = 'reid' . time() . str_random(5);
        }
        $transaction_id = strtoupper($transaction_id);

        $payments_data = [
            'name' => session('cart.full_name'),
            'email' => session('cart.email'),

            'user_id' => $user_id,
            'campaign_id' => $campaign->id,
            'reward_id' => session('cart.reward_id'),

            'amount' => $amount,
            'payment_method' => 'cash',
            'status' => 'pending',
            'currency' => $currency,
            'local_transaction_id' => $transaction_id,

            'contributor_name_display' => session('cart.contributor_name_display'),

        ];
        $newPayment = Payment::create($payments_data);
        $request->session()->forget('cart');
        return $this->paymentSuccess($newPayment,'cashPayment');

    }


    /**
     * @param $payment
     * @param $type
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paymentSuccess($payment,$type)
    {
        try {
            if($payment){
                $user = $payment->user;

                $content = '';
                switch ($type) {
                    case 'bankTransfer':
//                        break;
                    case 'bankCard':
//                        $when = now()->addMinutes(1);
                        $when = 20;
                        $tledgerApiController = new TledgerApiController();
                        $amount = round(($payment->amount / env("SUF_TO_TND")) * 1000) ;
                        $tledgerApiController->sendMoney($amount,$user->tledger_wallet_id);
                        Log:info("Paiement Smt Succées id: ".$payment->id);


                        // Génération de pdf
                        $amount = $payment->amount;
                        $numberToWords = new NumberToWords();
                        $numberTransformer = $numberToWords->getNumberTransformer('fr');
                        $amount_letters = $numberTransformer->toWords($amount);
                        $attachPath = "tmp/payment_validation_pdf_".time().".pdf";
                        PDF::loadView('payment_validation_pdf',compact('amount','amount_letters','user')) ->save($attachPath);

                        // Mail for startup
                        $startupUser = User::find($payment->campaign->user->id);
                        $startupNotification = new UserParticipationNotification();
                        $startupUserName = $payment->campaign->user->name . " " . $payment->campaign->user->firstname;
                        if($payment->campaign->for_purchase_funds){
                            $startupNotification->email = env('ADMIN_MAIl_NOTIFICATION');
                            $startupUserName = '';
                            $startupNotification->attachPath = public_path($attachPath);
                            $startupNotification->attachName= "Preuve_de_souscription.pdf";
                            $startupNotification->attachType= "application/pdf";
                        }
                        $startupNotification->subject = trans("app.subject_new_participation");
                        $startupNotification->content = trans('app.mail_hello').trans('app.startup_success_payment_bank_card', ['user_name' => $startupUserName, 'investor_name'=>$user->name." ".$user->first_name,'amount'=>$payment->amount,'currency'=>$payment->currency]);
                        $startupUser->notify($startupNotification->delay($when));

                        // Mail for investor
                        $investorNotification = new UserParticipationNotification();
                        $investorNotification->subject = trans("app.subject_payment_confirmation");
                        $content = trans('app.investor_success_payment_bank_card', ['campaign_name' => $payment->campaign->title , 'today'=>Carbon::now()->format('d/m/Y'),'amount'=>$payment->amount,'currency'=>$payment->currency,'transaction_id'=>$payment->local_transaction_id]);
                        $investorNotification->content = trans('app.mail_hello_user',['user_name'=>$user->name." ".$user->first_name]).$content.trans('app.thanks_for_participation');
                        $investorNotification->attachPath = public_path($attachPath);
                        $investorNotification->attachName= "Preuve_de_souscription.pdf";
                        $investorNotification->attachType= "application/pdf";
                        $user->notify($investorNotification->delay($when));
                        unlink(public_path($attachPath));

                        // Mail ERROR SUF TRANSFER
                        if($tledgerApiController->connectionError || $tledgerApiController->error){
                            Log::error("paymentSuccess: Impossible de se connecter à Tledger");
                            $payment->tledger_transfer_status = Payment::FAILED_PAYMENT_STATUS;
                            $payment->save();
                            $startupNotification->email = env('ADMIN_MAIl_NOTIFICATION');
                            $startupNotification->subject = trans("app.suf_transfer_error_subject");
                            $startupNotification->content = trans('app.mail_hello').trans('app.suf_transfer_error_content', ['payment_id' => $payment->id]);
                            $startupUser->notify($startupNotification->delay($when));
                        }else{
                            $payment->tledger_transfer_status = Payment::DONE_PAYMENT_STATUS;
                        }
                        $payment->save();
//                        $emailJob = (new SendSuccessPaymentEmail($payment->id))->delay(20);
//                        dispatch($emailJob);
                        break;
                }
                session(['payment_success_content' => $content]);
                return redirect()->to('payment_success');
            }else{
                return redirect()->to('home');
            }
        } catch (Exception $e) {
            echo $e->getMessage();die;
            return false;
        }
    }
}
