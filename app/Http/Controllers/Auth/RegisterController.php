<?php

namespace App\Http\Controllers\Auth;

use App\Campaign;
use App\Http\Controllers\Auth\TledgerApiController;
use App\Team;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        try {
            $tledgerApiController = new TledgerApiController();
            if($tledgerApiController->connectionError){
                return redirect()->back()->with('error', trans('app.tledger_api_connection_error'));
            }
            $tledgerApiController->register($request);
            if ($tledgerApiController->error) {
                $errors = [];
                foreach ($tledgerApiController->errors as $error) {
                    $field = $error->source->field;
                    if($error->source->field == "phoneNumber")
                        $field = "phone";
                    if($error->source->field == "firstName")
                        $field = "first_name";
                    if($error->source->field == "lastName")
                        $field = "name";
                    if($error->source->field == "confirmPassword")
                        $field = "password_confirmation";
                    $errors[$field] = $error->message;
                }
                return redirect()->to(url()->previous() . '#register')->with('tledger.registration.errors', $errors);
            } else {
                $tledgerUserWallets = $tledgerApiController->getUserWallets($tledgerApiController->accessToken);
                $wallet_id = $tledgerUserWallets['data']['id'];
                $request->merge([
                    'tledger_access_token' => $tledgerApiController->accessToken,
                    'tledger_wallet_id' => $wallet_id,
                ]);
                event(new Registered($user = $this->createInvestor($request->all())));

                $this->guard()->login($user);

                return $this->registered($request, $user)  ?: redirect($this->redirectPath()."#register");
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function investorBuisnessValidator(array $data)
    {
        $required = [
            'type' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
            'cgu' => 'required',
            'phone' => 'required',
            'first_name' => 'required|max:255',
            'email' => Rule::unique('users')->where(function ($query) {
                return $query->where('type', User::USER_TYPE_INVESTOR_BUISNESS_ANGEL);
            })
        ];
        $validator =  Validator::make($data, $required,
            [
                'cgu.required' => trans('app.register_cgu'),
                'email.unique' => trans('app.email_already_taken')
            ]);
        return $validator;

    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function createInvestor(array $data)
    {
        if (!array_key_exists('tledger_access_token', $data)) {
            $data['tledger_access_token'] = '';
        }
        return User::create([
            'type' => $data['type'],
            'name' => $data['name'],
            'first_name' => $data['first_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'user_type' => 'user',
            'active_status' => 1,
            'tledger_access_token' => $data['tledger_access_token'],
            'tledger_wallet_id' => $data['tledger_wallet_id'],
        ]);
    }



    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorStartup(array $data)
    {
        $required = [
            'type' => 'required',
            'name' => 'required|max:255',
//            'email' => Rule::unique('users')->where(function ($query) {
//                return $query->where('type', User::USER_TYPE_STARTUP);
//            }),
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'cgu' => 'required',
            'startup_name' => 'required|max:255',
            'title' => 'required',
            'legal_form' => 'required',
            'unique_identifier' => 'required',
            'public_presentation' => 'required|mimes:jpeg,png,pdf',
            'other_document' => 'mimes:jpeg,png,pdf',
            'company_identity' => 'required|mimes:jpeg,png,pdf',
            'logo' => 'required|mimes:jpeg,png,pdf',
        ];

       $validator =  Validator::make($data, $required,
            [
                'cgu.required' => trans('app.register_cgu'),
                'email.unique' => trans('app.email_already_taken')
            ]);
        return $validator;

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function createStartup(array $data)
    {

        return User::create([
            'type' => $data['type'],
            'name' => $data['name'],
            'first_name' => $data['first_name'],
            'phone' => $data['phone'],
            'startup_name' => $data['startup_name'],
            'email' => $data['email'],
            'website' => $data['website'],
            'password' => bcrypt($data['password']),
            'user_type' => 'user',
            'active_status' => 1,
            'legal_form' => $data['legal_form'],
            'unique_identifier' => $data['unique_identifier'],
            'tledger_access_token' => $data['tledger_access_token'],
            'tledger_wallet_id' => $data['tledger_wallet_id'],
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function registerStartup(Request $request)
    {

        try {
            $tledgerApiController = new TledgerApiController();
            if($tledgerApiController->connectionError){
                return redirect()->back()->with('error', trans('app.tledger_api_connection_error'));
            }
            $validator = $this->validatorStartup($request->all());
            if ($validator->fails()) {
                return redirect()->to(url()->previous() . '#register')->withErrors($validator)->withInput();
            }
            $tledgerApiController->register($request);
            if ($tledgerApiController->error) {
                $errors = [];
                foreach ($tledgerApiController->errors as $error) {
                    $field = $error->source->field;
                    if($error->source->field == "phoneNumber")
                        $field = "phone";
                    if($error->source->field == "firstName")
                        $field = "first_name";
                    if($error->source->field == "lastName")
                        $field = "name";
                    if($error->source->field == "confirmPassword")
                        $field = "password_confirmation";
                    $errors[$field] = $error->message;
                }
                return redirect()->to(url()->previous() . '#register')->with('tledger.registration.errors', $errors);
            } else {
                $tledgerUserWallets = $tledgerApiController->getUserWallets($tledgerApiController->accessToken);
                $wallet_id = $tledgerUserWallets['data']['id'];
                $request->merge([
                    'tledger_access_token' => $tledgerApiController->accessToken,
                    'tledger_wallet_id' => $wallet_id,
                ]);
                $user = $this->createStartup($request->all());
                event(new Registered($user));
                if($user){
                    $user->logo = $this->uploadFile($user->id, $request, 'logo');
                    $user->company_identity = $this->uploadFile($user->id, $request, 'company_identity');
                    $user->save();
                    Campaign::create([
                        "user_id"=>$user->id,
                        "title"=>$request->title,
                        "slug"=>str_replace(' ', '-',$request->title),
                        "video"=>$request->video,
                        "start_date"=> Carbon::now(),
                        "end_date"=>Carbon::now()->addMonths($request->companion_duration),
                        "goal"=>$request->goal,
                        "status"=>0,
                        "is_funded"=>0,
                        "public_presentation"=> $this->uploadFile($user->id, $request, 'public_presentation'),
                        "other_document"=>$this->uploadFile($user->id, $request,'other_document')
                    ]);
                    $i = 0;
                    foreach ($request->function_team as $item) {
                        $team =new Team();
                        $team->user_id = $user->id;
                        $team->fonction = $item;
                        $team->name = $request->name_team[$i];
                        $team->social_network_link = json_encode($request->social_network_team[$i]);
                        $team->save();
                        $i++;
                    }
                    $this->guard()->login($user);
                    return $this->registered($request, $user) ?: redirect($this->redirectPath());
                }
            }
        } catch (Exception $e) {
            return false;
        }

    }


    /**
     * @param Request $request
     * @param $user
     */
    protected function registered(Request $request, $user)
    {
        $content = $adminContent = '';
        if($user->is_startup()){
            $content = trans("app.confirm_inscription_startup");
            $adminContent = trans("app.admin_startup_new_inscription_content",['type'=>"Startup","startup_name"=>$user->startup_name,"name"=>$user->name." ".$user->first_name,"phone"=>$user->phone]);
        }
        if($user->is_investor()){
            $content = trans("app.confirm_inscription_investor");
            $adminContent = trans("app.admin_investor_new_inscription_content",['type'=>"Investisseur","name"=>$user->name." ".$user->first_name,"phone"=>$user->phone]);
        }
        $notification = new UserRegisteredNotification($user);
        $notification->subject = trans('app.confirm_inscription');
        $notification->content = trans('app.mail_hello').$content;

        $user->notify($notification->delay(20));

        $notification->email = env('ADMIN_MAIl_NOTIFICATION');
        $notification->forAdmin = true;
        $notification->subject = trans('app.new_inscription');
        $notification->content = trans('app.mail_hello').$adminContent;

        $user->notify($notification->delay(20));


    }


    /**
     * @param null $id
     * @param Request $request
     * @param String $fileName
     */
    public function uploadFile($id, Request $request, $fileName)
    {
        if ($request->hasFile($fileName)) {
            $rules = [$fileName => 'mimes:jpeg,png,pdf',];
            $this->validate($request, $rules);
            $file = $request->file($fileName);
            $file_name = $fileName.'_'. $file->getClientOriginalName();
            $upload_dir = './uploads/users/' . $id;
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
        }
    }
}
