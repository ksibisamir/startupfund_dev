<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Category;
use App\Country;
use App\Team;
use App\User;
use App\Withdrawal_preference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    public function index()
    {
        $title = trans('app.users');
        $users = User::orderBy('name', 'asc')->paginate(20);
        $users_count = User::count();
        return view('admin.users', compact('title', 'users', 'users_count'));
    }

    public function show($id = 0)
    {
        if ($id) {
            $title = trans('app.profile');
            $user = User::find($id);

            $is_user_id_view = true;
            return view('admin.profile', compact('title', 'user', 'is_user_id_view'));
        }
    }

    /**
     * @param $id
     * @param null $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function statusChange($id, $status = null)
    {
        if (config('app.is_demo')) {
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }

        $user = User::find($id);
        if ($user && $status) {
            if ($status == 'approve') {
                $user->active_status = 1;
                $user->save();

            } elseif ($status == 'block') {
                $user->active_status = 2;
                $user->save();
            }
        }
        return back()->with('success', trans('app.status_updated'));
    }

    /**
     * @param $id
     * @param null $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ActivateAccount(Request $request)
    {
        $required = [
            'accept' => 'required',
        ];
        $validator = Validator::make($request->all(), $required,
            [
                'accept.required' => trans('app.accept_condition_required'),
            ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous() . '')->withErrors($validator)->withInput();
        }
        $user = Auth::User();
        if ($user) {
            $user->active_status = 1;
            $user->save();
        }
        return redirect(route('investor_profile_edit'));
    }


    public function profile()
    {
        $title = trans('app.profile');
        $user = Auth::user();
        return view('admin.profile', compact('title', 'user'));
    }

    /**
     * @param null $id
     */
    public function profileEdit($id = null)
    {
        $user = Auth::user();
        if ($user->is_investor()) {
            $this->profileEditInvestor();
        } elseif ($user->is_startup()) {
            $this->profileEditStartup();
        } else {
            $title = trans('app.personal_information');
            $countries = Country::all();
            if ($id) {
                $user = User::find($id);
            }
            return view('admin.profile_edit_step_1', compact('title', 'user', 'countries'));
        }
    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profileEditInvestor($id = null)
    {
        $title = trans('app.personal_information');
        $user = Auth::user();

        $countries = Country::all();

        if ($id) {
            $user = User::find($id);
        }

        return view('admin.investor.profile_edit_step_1', compact('title', 'user', 'countries'));
    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profileEditStartup($id = null)
    {
        $title = trans('app.personal_information');

        $user = Auth::user();

        $countries = Country::all();

        $campaigns = $user->my_campaigns()->where('status', 1)->first();
        $team = $user->teams();

        return view('admin.startup.profile_edit', compact('title', 'user', 'countries', 'campaigns', 'team'));

    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profileEditStartupPost(Request $request, $id = null)
    {
        $rules = [
            'startup_name' => 'required',
            'legal_form' => 'required',
            'unique_identifier' => 'required',
        ];

        $this->validate($request, $rules);

        $user = Auth::user();

        if($user->logo || $user->logo == ''){
            $rules['logo'] = 'required';
        }

        if($user->company_identity || $user->company_identity == ''){
            $rules['company_identity'] = 'required';
        }

        $user->startup_name = $request->startup_name;
        $user->website = $request->website;
        $user->legal_form = $request->legal_form;
        $user->unique_identifier = $request->unique_identifier;
        $user->startup_act_label = $request->startup_act_label;

        if ($user->logo != $request->logo && $request->hasFile('logo')) {
            if ($user->logo) {
                $filePath = './uploads/users/' . Auth::user()->id . '/' . $user->logo;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $user->logo = $this->uploadFileByName($request, 'logo');
        }

        if ($user->company_identity != $request->company_identity && $request->hasFile('company_identity')) {
            if ($user->company_identity) {
                $filePath = './uploads/users/' . Auth::user()->id . '/' . $user->company_identity;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $user->company_identity = $this->uploadFileByName($request, 'company_identity');
        }
        $update = $user->save();

        $user->teams()->delete();

        if($request->has('function_team')){
            $i = 0;
            foreach ($request->function_team as $item) {
                if(empty($request->name_team[$i])){
                    return back()->with('error', trans('app.something_went_wrong'))->withInput($request->input());
                }
                $team = new Team();
                $team->user_id = $user->id;
                $team->fonction = $item;
                $team->name = $request->name_team[$i];
                $team->social_network_link = json_encode($request->social_network_team[$i]);
                $team->save();
                $i++;
            }
        }


        if ($update) {
            return redirect(route('startup_profile_edit'))->with('success', trans('app.profile_edit_success_msg'));
        }
        return back()->with('error', trans('app.something_went_wrong'))->withInput($request->input());
    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profileEditStep2($id = null)
    {
        $title = trans('app.property_status');
        $user = Auth::user();

        if ($id) {
            $user = User::find($id);
        }
        return view('admin.investor.profile_edit_step_2', compact('title', 'user'));
    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profileEditStep3($id = null)
    {
        $title = trans('app.investment_experience');
        $user = Auth::user();

        if ($id) {
            $user = User::find($id);
        }
        if(isJSON($user->financial_instruments)) {
            $user->financial_instruments = json_decode($user->financial_instruments);
        } else {
            $user->financial_instruments = array();
        }
        return view('admin.investor.profile_edit_step_3', compact('title', 'user'));
    }

    /**
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profileEditStep4($id = null)
    {
        $title = trans('app.investment_objectives');
        $user = Auth::user();
        if ($id) {
            $user = User::find($id);
        }
        $objectives_sought = array();
        if(isJSON($user->objectives_sought)){
            $objectives_sought = json_decode($user->objectives_sought);
        }

        return view('admin.investor.profile_edit_step_4', compact('title', 'user', 'objectives_sought'));
    }


    /**
     * @param null $id
     * @param Request $request
     */
    public function uploadFile($id = null, Request $request)
    {

        $user = Auth::user();
        if ($id) {
            $user = User::find($id);
        }
        if ($request->hasFile('company_identity')) {
            $rules = ['company_identity' => 'mimes:jpeg,png,pdf',];
            $this->validate($request, $rules);
            $file = $request->file('company_identity');
            $file_name = $file->getClientOriginalName();
            $upload_dir = './uploads/users/' . $user->id;
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            try {
                $file->move($upload_dir, $file->getClientOriginalName());
                $previous_company_identity = $user->company_identity;
                $user->company_identity = $file_name;
                $user->company_identity_validate_status = '';
                $user->save();
                if ($previous_company_identity) {
                    if (file_exists($upload_dir . $previous_company_identity)) {
                        unlink($upload_dir . $previous_company_identity);
                    }
                }
                return back()->with('success', trans('app.profile_edit_success_msg'));
            } catch (\Exception $e) {
                return $e->getMessage();
                return back()->with('error', trans('app.profile_edit_error_msg'));
            }
        }
    }

    /**
     * @param null $id
     * @param Request $request
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function profileEditStep1Post($id = null, Request $request)
    {
        if (config('app.is_demo')) {
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }
        $user = Auth::user();

        if ($id) {
            $user = User::find($id);
        } elseif ($request->input('id')) {
            $id = $request->input('id');
            $user = User::find($id);
        }
        switch ($request->input('btn-action')) {

            case 'save':
                $userInputs = array_except($request->input(), ['_token', 'photo','user_id', 'btn-action', 'function_team', 'name_team', 'social_network_team', 'profile']);
                $inputs = array_except($request->input(), ['_token','user_id', 'photo', 'btn-action', '']);
                if ($request->profile == User::USER_TYPE_STARTUP) {
                    $rules = [
//                        'email' => 'required|email|unique:users,email,' . $user->id,
//                        'bank_account_num' => 'string|min:20|max:20',
                        'cin' => 'required',
                        'name' => 'required',
                        'startup_name' => 'required',
                    ];
                }
                if ($request->profile == User::USER_TYPE_INVESTOR_BUISNESS_ANGEL) {
                    $rules = [
//                        'email' => 'required|email|unique:users,email,' . $user->id,.
                        'cin' => 'required',
                        'first_name' => 'required',
                        'name' => 'required',
                        'registration_type' => 'required',
                    ];
                }
                $this->validate($request, $rules);

                $user->update($userInputs);

                if ($request->type == User::USER_TYPE_STARTUP) {
                    $user->teams()->delete();
                    $i = 0;

                    if (array_key_exists('function_team', $inputs)) {
                        foreach ($inputs['function_team'] as $item) {
                            $team = new Team();
                            $team->user_id = $user->id;
                            $team->fonction = $inputs['function_team'][$i];
                            $team->name = $inputs['name_team'][$i];
                            $team->social_network_link = json_encode($inputs['social_network_team'][$i]);
                            $team->save();
                            $i++;
                        }
                    }
                }
                if ($request->hasFile('photo')) {
                    $rules = ['photo' => 'mimes:jpeg,jpg,png'];
                    $this->validate($request, $rules);

                    $image = $request->file('photo');
                    $file_base_name = str_replace('.' . $image->getClientOriginalExtension(), '', $image->getClientOriginalName());


                    $resized = Image::make($image)->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $image_name = strtolower(time() . str_random(5) . '-' . str_slug($file_base_name)) . '.' . $image->getClientOriginalExtension();

                    $upload_dir = './uploads/avatar/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }

                    $imageFileName = $upload_dir . $image_name;
                    try {
                        //Uploading thumb
                        $resized->save($imageFileName);

                        $previous_photo = $user->photo;
                        $user->photo = $image_name;
                        $user->save();

                        if ($previous_photo) {
                            if (file_exists($upload_dir . $previous_photo)) {
                                unlink($upload_dir . $previous_photo);
                            }
                        }

                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }
                }
                break;
            case 'validate_company_identity':
                try {
                    $user->company_identity_validate_status = User::COMPANY_IDENTITY_VALIDATED;
                    $user->save();
                } catch (Exception $e) {
                    return $e->getMessage();
                }
                if ($id) {
                    return redirect(route('users_edit_step_1', ['id' => $id]));
                }
                return redirect(route('profile_edit'));
                break;

            case 'reject_company_identity':
                try {
                    $user->company_identity_validate_status = User::COMPANY_IDENTITY_REJECTED;
                    $user->save();
                } catch (Exception $e) {
                    return false;
                }
                if ($id) {
                    return redirect(route('users_edit_step_1', ['id' => $id]));
                }
                return redirect(route('profile_edit'));
                break;
        }
        if ($request->profile == User::USER_TYPE_STARTUP) {
            return back()->with('success', trans('app.profile_edit_success_msg'));
        }
        if ($id) {
            return redirect(route('users_edit_step_2', ['id' => $id]));
        }

        return redirect(route('investor_profile_edit_step2'));
    }


    /**
     * @param null $id
     * @param Request $request3
     */
    public function profileEditStep2Post($id = null, Request $request)
    {
        $user = Auth::user();

        if ($id) {
            $user = User::find($id);
        } elseif ($request->input('id')) {
            $id = $request->input('id');
            $user = User::find($id);
        }

        $inputs = array_except($request->input(), ['_token']);
        $user->update($inputs);

        if ($id) {
            return redirect(route('users_edit_step_3', ['id' => $id]));
        }
        return redirect(route('investor_profile_edit_step3'));
    }

    /**
     * @param null $id
     * @param Request $request
     */
    public function profileEditStep3Post($id = null, Request $request)
    {
        $user = Auth::user();

        if ($id) {
            $user = User::find($id);
        } elseif ($request->input('id')) {
            $id = $request->input('id');
            $user = User::find($id);
        }

        $financialInstruments = array();
        if ($request->input('fcp_actions')){
            $financialInstruments[] = 'fcp_actions';
        }
        if ($request->input('bond_funds')){
            $financialInstruments[] = 'bond_funds';
        }
        if ($request->input('capital_investment')){
            $financialInstruments[] = 'capital_investment';
        }
        $inputs = array_except($request->input(), ['_token','fcp_actions','bond_funds','capital_investment']);
        $inputs['financial_instruments'] = json_encode($financialInstruments);

        $user->update($inputs);
        if ($id) {
            return redirect(route('users_edit_step_4', ['id' => $id]));
        }
        return redirect(route('investor_profile_edit_step4'));
    }

    /**
     * @param null $id
     * @param Request $request
     */
    public function profileEditStep4Post($id = null, Request $request)
    {
        $user = Auth::user();
        if ($id) {
            $user = User::find($id);
        } elseif ($request->input('id')) {
            $id = $request->input('id');
            $user = User::find($id);
        }

        $inputs = array_except($request->input(), ['_token']);
        $data = array();
        if($request->tax_reduction){
            array_push($data, 'tax_reduction');
        }
        if($request->return_on_my_investments){
            array_push($data, 'return_on_my_investments');
        }
        if($request->diversification_of_my_portfolio){
            array_push($data, 'diversification_of_my_portfolio');
        }
        if($request->objectives_sought_other){
            array_push($data, 'objectives_sought_other');
            $user->objectives_sought_other = $request->objectives_sought_other_input;
        }

        $user->objectives_sought = json_encode($data);
        $user->save();
        if ($id) {
            return redirect(route('users_edit_step_1', ['id' => $id]));
        }
        return redirect(route('investor_profile_edit'))->with('success', trans('app.profile_edit_success_msg'));

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function withdrawalPreference()
    {
        $title = trans('app.withdrawal_preference');
        $user = Auth::user();

        $countries = Country::all();
        return view('admin.withdrawal_preference', compact('title', 'user', 'countries'));
    }

    public function withdrawalPreferenceUpdate(Request $request)
    {
        $user_id = Auth::user()->id;
        $rules = [
            'default_withdrawal_account' => 'required'
        ];
        $this->validate($request, $rules);

        $data = [
            'default_withdrawal_account' => $request->default_withdrawal_account,
            'paypal_email' => $request->paypal_email,
            'bank_account_holders_name' => $request->bank_account_holders_name,
            'bank_account_number' => $request->bank_account_number,
            'swift_code' => $request->swift_code,
            'bank_name_full' => $request->bank_name_full,
            'bank_branch_name' => $request->bank_branch_name,
            'bank_branch_city' => $request->bank_branch_city,
            'bank_branch_address' => $request->bank_branch_address,
            'country_id' => $request->country_id,
            'user_id' => $user_id,
        ];

        $withdrawal_preference = Withdrawal_preference::whereUserId($user_id)->first();
        if ($withdrawal_preference) {
            $withdrawal_preference->update($data);
        } else {
            Withdrawal_preference::create($data);
        }

        return redirect()->back()->with('success', trans('app.changes_has_been_saved'));

    }

    public function changePassword()
    {
        $title = trans('app.change_password');
        return view('admin.change_password', compact('title'));
    }

    public function changePasswordPost(Request $request)
    {
        if (config('app.is_demo')) {
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required',
        ];
        $this->validate($request, $rules);

        $old_password = $request->old_password;
        $new_password = $request->new_password;
        //$new_password_confirmation = $request->new_password_confirmation;

        if (Auth::check()) {
            $logged_user = Auth::user();

            if (Hash::check($old_password, $logged_user->password)) {
                $logged_user->password = Hash::make($new_password);
                $logged_user->save();
                return redirect()->back()->with('success', trans('app.password_changed_msg'));
            }
            return redirect()->back()->with('error', trans('app.wrong_old_password'));
        }
    }

    /**
     * @param null $id
     * @param Request $request
     * @param String $fileName
     */
    public function uploadFileByName(Request $request, $fileName)
    {
        if ($request->hasFile($fileName)) {
            $rules = [$fileName => 'mimes:jpeg,png,pdf',];
            $this->validate($request, $rules);
            $file = $request->file($fileName);
            $file_name = $fileName . '_' . $file->getClientOriginalName();
            $upload_dir = './uploads/users/' . Auth::user()->id;
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            try {
                $file->move($upload_dir, $file_name);
                return $file_name;
            } catch (\Exception $e) {
                return $e->getMessage();
                //return back()->with('error', trans('app.profile_edit_error_msg'));
            }
        } else {
            return null;
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function investorAcceptContract(Request $request)
    {
        $required = [
            'accept' => 'required',
        ];
        $validator = Validator::make($request->all(), $required,
            [
                'accept.required' => trans('app.accept_condition_required'),
            ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous() . '')->withErrors($validator)->withInput();
        }
        $user = Auth::User();
        if ($user) {
            $user->investor_contract_accepted = 1;
            $user->save();
        }
        return redirect(route('investor_profile_edit'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function startupAcceptContract(Request $request)
    {
        $required = [
            'accept' => 'required',
        ];
        $validator = Validator::make($request->all(), $required,
            [
                'accept.required' => trans('app.accept_condition_required'),
            ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous() . '')->withErrors($validator)->withInput();
        }
        $user = Auth::User();
        if ($user) {
            $user->startup_contract_accepted = 1;
            $user->save();
        }
        return redirect(route('startup_profile_edit'));
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function startupList()
    {
        $list = User::select('id', 'startup_name')->where("active_status",1)->where('startup_contract_accepted',1)
            ->has('campaign')
            ->with('campaign:id,goal,short_description,total_funded,end_date,user_id')
            ->get();

        return response()->json($list);
    }

    public function myCampaigns(){
        $user = Auth::user();

        $campaign = $user->campaign()->latest()->first();
        if(!$campaign) {
            $campaign = new Campaign();
        }

        $title = trans('app.edit_campaign');
        $categories = Category::all();
        $countries = Country::all();

        return view('admin.my_campaigns', compact('title', 'categories', 'countries', 'campaign'));
    }

    public function myCampaignsUpdate(Request $request) {
        $user = Auth::User();

        $rules = [
            'category' => 'required',
            'title' => 'required',
            'short_description' => 'required|max:200',
            'description' => 'required',
            'goal' => 'required',
            'country_id' => 'required',
        ];

        $this->validate($request, $rules);

        if ($request->id){
            $campaign = Campaign::find($request->id);
        } else {
            $campaign = new Campaign();
        }


        if ($campaign->status) {
            return back()->with('error', trans('app.cant_update_campaign_validated'))->withInput($request->input());
        }

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

        $public_presentation = $campaign->public_presentation;
        if ($request->hasFile('public_presentation')) {
            $rules = ['public_presentation' => 'mimes:jpeg,png,pdf',];
            $this->validate($request, $rules);
            $file = $request->file('public_presentation');
            $file_name = 'public_presentation_'. $file->getClientOriginalName();
            $upload_dir = './uploads/users/' . $user->id;
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            try {
                $file->move($upload_dir, $file_name);

            } catch (\Exception $e) {
                return $e->getMessage();
                //return back()->with('error', trans('app.profile_edit_error_msg'));
            }

            //Delete old image
            if ($public_presentation) {
                if (file_exists($upload_dir . $public_presentation)) {
                    unlink($upload_dir . $public_presentation);
                }
            }
            $public_presentation = $file_name;
        }

        $other_document = $campaign->other_document;
        if ($request->hasFile('other_document')) {
            $rules = ['other_document' => 'mimes:jpeg,png,pdf',];
            $this->validate($request, $rules);
            $file = $request->file('other_document');
            $file_name = 'other_document_'. $file->getClientOriginalName();
            $upload_dir = './uploads/users/' . $user->id;
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            try {
                $file->move($upload_dir, $file_name);

            } catch (\Exception $e) {
                return $e->getMessage();
                //return back()->with('error', trans('app.profile_edit_error_msg'));
            }

            //Delete old image
            if ($other_document) {
                if (file_exists($upload_dir . $other_document)) {
                    unlink($upload_dir . $other_document);
                }
            }
            $other_document = $file_name;
        }
        $data = [
            'user_id' => $user->id,
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
            'public_presentation' => $public_presentation,
            'other_document' => $other_document,

        ];
        if ($campaign->id != '' || $campaign->id != null) {
            $campaign = Campaign::whereId($campaign->id)->update($data);
        } else {
            $campaign = Campaign::create($data);
        }


        if ($campaign) {
            return back()->with('success', trans('app.campaign_created'));
        }
        return back()->with('error', trans('app.something_went_wrong'))->withInput($request->input());
    }
}
