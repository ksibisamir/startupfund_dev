<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\TledgerApiController;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login_register');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginStartupForm()
    {
        return view('auth.login_startup');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegisterStartupForm()
    {
        return view('auth.register_startup');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginAdminForm()
    {
        return view('auth.login_admin');
    }

    public function allowAccess(Request $request){
        try {
            if($request->input('login') == env('ALLOW_ACCESS_LOGIN') && $request->input('password') == env('ALLOW_ACCESS_PASSWORD')){
                setcookie("startupfund-allowed-access", 1);
                return Redirect::to(route('home'));
            }else{
                return redirect()->back()->with('error', 'Login ou Mot de passe incorrect');
            }
        } catch (Exception $e) {
           return false;
        }
    }
    private function login(Request $request, $status, $type)
    {
        $tledgerApiController = new TledgerApiController();
        if ($tledgerApiController->connectionError) {
            Log::error("Login: Impossible de se connecter à Tledger");
            return redirect()->back()->with('error', trans('app.tledger_api_connection_error'));
        }
        $this->validateLogin($request);

        if (get_option('enable_recaptcha_login') == 1) {
            $this->validate($request, array('g-recaptcha-response' => 'required'));

            $secret = get_option('recaptcha_secret_key');
            $gRecaptchaResponse = $request->input('g-recaptcha-response');
            $remoteIp = $request->ip();

            $recaptcha = new \ReCaptcha\ReCaptcha($secret);
            $resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);
            if (!$resp->isSuccess()) {
                return redirect()->back()->with('error', 'reCAPTCHA is not verified');
            }
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        try {
            $tledgerApiController->login($request);
            if ($tledgerApiController->error) {
                Log::info('Tentative de connexion à Tledger de la part de: ' . $request->input("email"));
                Auth::logout();
                $errors = [];
                foreach ($tledgerApiController->errors as $error) {
                    array_push($errors, $error->message);
                }
                return redirect()->to(url()->previous() . '#login')->with('tledger.login.errors', $errors);
            } else {
                if ($this->attemptLogin($request)) {
                    $user = Auth::user();
                    $request->merge([
                        'tledger_access_token' => $tledgerApiController->accessToken,
                    ]);
                    $user->tledger_access_token = $tledgerApiController->accessToken;
                    if (empty($user->tledger_wallet_id)) {
                        $tledgerUserWallets = $tledgerApiController->getUserWallets($tledgerApiController->accessToken);
                        $user->tledger_wallet_id = $tledgerUserWallets['data']['id'];
                    }
                    $user->save();
                    $tledgerApiController->getUserData($user->tledger_access_token);
                    if (session('cart')) {
                        return Redirect::to(route('checkout'));
                    }
                } else {
                    $tledgerApiController = new TledgerApiController();
                    $tledgerApiController->login($request);
                    if (!$tledgerApiController->error) {
                        $tledgerUserData = $tledgerApiController->getUserData($tledgerApiController->accessToken);
                        $tledgerUserWallets = $tledgerApiController->getUserWallets($tledgerApiController->accessToken);
                        $data = [
                            'type' => $type,
                            'name' => $tledgerUserData['data']['lastName'],
                            'first_name' => $tledgerUserData['data']['firstName'],
                            'email' => $tledgerUserData['data']['email'],
                            'phone' => $tledgerUserData['data']['phoneNumber'],
                            'password' => bcrypt($request->input('password')),
                            'user_type' => 'user',
                            'active_status' => $status,
                            'tledger_access_token' => $tledgerApiController->accessToken,
                            'tledger_wallet_id' => $tledgerUserWallets['data']['id'],
                        ];
                        $user = User::create($data);
                        Auth::guard()->login($user);
                        Log::info("Création d'un compte startup à partir d'un compte tledger: " . $request->input("email"));
                    }
                }
                Log::info("Connexion du compte: " . $request->input("email"));
                return $this->sendLoginResponse($request);
            }

        } catch (Exception $e) {
            return false;
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    /**
     * @param Request $request
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loginInvestor(Request $request)
    {
        return $this->login($request, 0, User::USER_TYPE_INVESTOR_BUISNESS_ANGEL);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loginStartup(Request $request)
    {
        return $this->login($request, 1, User::USER_TYPE_STARTUP);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loginAdmin(Request $request)
    {
        $this->validateLogin($request);

        if (get_option('enable_recaptcha_login') == 1) {
            $this->validate($request, array('g-recaptcha-response' => 'required'));

            $secret = get_option('recaptcha_secret_key');
            $gRecaptchaResponse = $request->input('g-recaptcha-response');
            $remoteIp = $request->ip();

            $recaptcha = new \ReCaptcha\ReCaptcha($secret);
            $resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);
            if (!$resp->isSuccess()) {
                return redirect()->back()->with('error', 'reCAPTCHA is not verified');
            }

        }

        //Check if active account
        $user = User::whereEmail($request->email)->first();
        if ($user) {
            if ($user->active_status != 1) {
                return redirect()->back()->with('error', trans('app.user_account_wrong'));
            }
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLoginAdmin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    /***
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        User::where('id', $request->user()->id)->update(['tledger_access_token' => '']);

        Log::info('Déconnexion du compte: ' .$request->user()->email);

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }


    /**
     * @param Request $request
     * @return mixed
     */
    private function attemptLoginInvestor(Request $request)
    {
        $request->merge([
            'type' => User::USER_TYPE_INVESTOR_BUISNESS_ANGEL,
        ]);
        return Auth::guard()->attempt($request->only('email', 'type', 'password'), $request->filled('remember'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function attemptLoginStartup(Request $request)
    {
        $request->merge([
            'type' => User::USER_TYPE_STARTUP,
        ]);
        return Auth::guard()->attempt($request->only('email', 'type', 'password'), $request->filled('remember'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function attemptLoginAdmin(Request $request)
    {
        $request->merge([
            'user_type' => 'admin',
        ]);
        return Auth::guard()->attempt($request->only('email', 'user_type', 'password'), $request->filled('remember'));
    }


}
