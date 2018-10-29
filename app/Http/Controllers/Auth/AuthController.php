<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '';

    protected $loginPath = 'login';

    protected $username = 'username';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getLogout', 'getSignupThankYou']]);
        $this->middleware('auth', ['only' => ['getSignupThankYou']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255|alpha_dash|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'birth_day' => 'date',
            'country_code' => 'required|exists:countries,code',
            'license_plate' => 'required_if:register_for_alerts,on',
            'license_plate_country_code' => 'required_if:register_for_alerts,on|exists:countries,code',
            'g-recaptcha-response' => config('app.recaptcha') ? 'required|recaptcha' : ''
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create($data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->route('auth::getSignup')
                ->withInput($request->except('password', 'passsword_confirmation'))
                ->withErrors($validator);
        }

        $request->merge([
            'registration_ip' => $request->ip(),
            'last_ip' => $request->ip(),
            'user_agent' => user_agent(),
            'last_login' => Carbon::now(),
            'last_last_login' => Carbon::now()
        ]);

        $user = $this->create($request->all());

        //$user->assignRole('user_autoapprove', false);

        if (!is_null($request->license_plate)) {
            $user->addPlate(['name' => $request->license_plate, 'country_code' => $request->license_plate_country_code]);
        }

        Auth::login($user);
        session(['new_signup' => true]);

        return redirect()->route('auth::getSignupThankYou');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $this->loginUsername() => 'required',
            'password' => 'required',
            'g-recaptcha-response' => config('app.recaptcha') ? 'required|recaptcha' : ''
        ]);

        if ($validator->fails()) {
            return redirect($this->loginPath)
                ->withInput($request->only($this->loginUsername(), 'remember'))
                ->withErrors($validator);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        } else {
            $old_user = User::whereUsername($request->username)->whereRaw('password = MD5(CONCAT("' . $request->password . '",salt))')->first();

            if ($old_user) {
                Auth::login($old_user);

                return $this->handleUserWasAuthenticated($request, $throttles);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    protected function authenticated(Request $request, User $user)
    {
        $user->updateLoginInfo($request);

        return redirect()->intended($user->url);
    }

    public function getSocialLogin($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function getSocialLoginCallback(Request $request, $provider)
    {
        $user = Socialite::driver($provider)->user();

        $exists = User::where($provider . '_id', $user->id)
            ->orWhere('email', $user->email)
            ->first();

        if ($exists) {
            $exists->update([$provider . '_id' => $user->id]);
            $exists->updateLoginInfo($request);

            Auth::login($exists);

            return redirect()->intended($exists->url);
        }

        $extract_name = explode(' ', $user->name);

        if ($provider == 'facebook' || $provider == 'twitter') {
            $avatar = $user->avatar_original;
        } elseif ($provider == 'vimeo') {
            $avatar = !is_null($user->user['pictures']) ? $user->user['pictures']['sizes'][3]['link'] : null;
        } elseif ($provider == 'google' && !is_null($user->avatar)) {
            $extract_avatar = explode('?sz=', $user->avatar);
            $avatar = count($extract_avatar) ? $extract_avatar[0] . '?sz=300' : null;
        } else {
            $avatar = null;
        }

        session(['social.provider' => $provider]);
        session(['social.id' => $user->id]);
        session(['social.username' => count($extract_name) ? strtolower($extract_name[0] . rand(10000, 90000)) : null]);
        session(['social.email' => $user->email]);
        session(['social.first_name' => count($extract_name) ? $extract_name[0] : null]);
        session(['social.last_name' => count($extract_name) && isset($extract_name[1]) ? $extract_name[1] : null]);
        session(['social.avatar' => $avatar]);

        return redirect()->route('auth::getSocialSignup');
    }

    public function getSocialSignup(Request $request)
    {
        if (!session()->has('social')) {
            return redirect()->route('auth::getLogin');
        }

        return view('auth.social');
    }

    public function postSocialSignup(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:255|alpha_dash|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'license_plate' => 'required_if:register_for_alerts,on',
            'license_plate_country_code' => 'required_if:register_for_alerts,on',
        ]);

        $request->merge([
            session('social.provider') . '_id' => session('social.id'),
            'registration_ip' => $request->ip(),
            'last_ip' => $request->ip(),
            'user_agent' => user_agent(),
            'last_login' => Carbon::now(),
            'last_last_login' => Carbon::now()
        ]);

        $user = $this->create($request->all());

        if (!is_null($request->license_plate)) {
            $user->addPlate(['name' => $request->license_plate, 'country_code' => $request->license_plate_country_code]);
        }

	$user->assignRole('user_autoapprove', false);

        Auth::login($user);

        session()->forget('social');
        session(['new_signup' => true]);

        return redirect()->route('auth::getSignupThankYou');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        if (session()->has('impersonating')) {
            Auth::loginUsingId(session('impersonator_id'));

            session()->forget('impersonating');
            session()->forget('impersonator_id');

            return redirect()->route('admin::getIndex');
        }

        Auth::logout();

        return redirect()->back();
    }

    public function getSignupThankYou()
    {
        if (!session()->has('new_signup')) {
            return redirect(auth()->user()->url);
        }

        return view('auth.signup-thank-you');
    }
}
