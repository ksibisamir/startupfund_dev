<?php

namespace App\Http\Controllers;

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

class StartupController extends Controller
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
        $validator =  Validator::make($request->all(), $required,
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
        return redirect(route('profile_edit'));
    }


    public function profile()
    {
        $title = trans('app.profile');
        $user = Auth::user();
        return view('admin.profile', compact('title', 'user'));
    }

    public function profileEdit($id = null)
    {
        $title = trans('app.personal_information');

        $user = Auth::user();

        $countries = Country::all();

        if ($id) {
            $user = User::find($id);
        }

        return view('admin.startup.profile_edit_step_1', compact('title', 'user', 'countries'));


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
        return view('admin.profile_edit_step_2', compact('title', 'user'));
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
        return view('admin.profile_edit_step_3', compact('title', 'user'));
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
        return view('admin.profile_edit_step_4', compact('title', 'user'));
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
        }

        switch ($request->input('btn-action')) {

            case 'save':

                $userInputs = array_except($request->input(), ['_token', 'photo', 'btn-action','function_team','name_team','social_network_team']);
                $inputs = array_except($request->input(), ['_token', 'photo', 'btn-action','']);

                $rules = [
                    'email' => 'required|email|unique:users,email,' . $user->id,
                    'bank_account_num' => 'string|min:20|max:20',
                    'cin' => 'string|min:8|max:8',
                    'name' => 'required',
                    'startup_name' => 'required',
                ];
                $validator = $this->validate($request, $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $user->update($userInputs);

                $user->teams()->delete();
                $i = 0;

                if(array_key_exists('function_team',$inputs)){
                    foreach ($inputs['function_team'] as $item) {
                        $team =new Team();
                        $team->user_id = $user->id;
                        $team->fonction = $inputs['function_team'][$i];
                        $team->name = $inputs['name_team'][$i];
                        $team->social_network_link = json_encode($inputs['social_network_team'][$i]);
                        $team->save();
                        $i++;
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
        return back()->with('success', trans('app.profile_edit_success_msg'));

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
        }
        $inputs = array_except($request->input(), ['_token']);
        $user->update($inputs);

        if ($id) {
            return redirect(route('users_edit_step_3', ['id' => $id]));
        }
        return redirect(route('profile_edit_step_3'));
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
        }

        $inputs = array_except($request->input(), ['_token']);
        $user->update($inputs);
        if ($id) {
            return redirect(route('users_edit_step_4', ['id' => $id]));
        }
        return redirect(route('profile_edit_step_4'));
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
        }

        $inputs = array_except($request->input(), ['_token']);
        $user->update($inputs);

        return redirect('dashboard')->with('success', trans('app.profile_edit_success_msg'));

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


}
