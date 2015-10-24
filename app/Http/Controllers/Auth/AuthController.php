<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserApi;
use App\EmailLogin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->middleware('csrf', ['only' => ['postLogin', 'postRegister', 'postEmailLogin']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function loginValidator(array $data)
    {
        return Validator::make($data, [            
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);
    }
    
    protected function registerValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'status' => 1,
            'verify' => 0,
        ]);
    }
    
    protected function setAPIToken() {
        $user_api_data = UserApi::firstorNew(array('user_id' => Auth::id()));
        $user_api_data->user_api_key = "apikey-".str_random(20);
        $user_api_data->save();          
    }
    
    protected function clearAPIToken() {
        $user_api_data = UserApi::find(Auth::id());
        if ($user_api_data) {
            $user_api_data->user_api_key = NULL;
            $user_api_data->save();
        }
    }
    
    protected function activateUser(User $user) {
        $user->verify = 1;
    }

    public function getLogin() {
        return View::make('auth.login');
    }
    
    public function postLogin() {
        $validator = $this->loginValidator(Input::all());
        if($validator->fails()) {
            return Redirect::action('Auth\AuthController@getLogin')->withErrors($validator)->withInput();
        } else {
            $remember = (Input::has('remember')) ? true : false;
            $auth = Auth::attempt([
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'status' => 1,
                'verify' => 1,
            ], $remember);
            
            if($auth) {
                $this->setAPIToken();
                return redirect('/');
            } else {
                return Redirect::action('Auth\AuthController@getLogin')->with('global', 'Incorrect password or account not activated');
            }
        }
    }
    
    public function getRegister() {
        return View::make('auth.register');
    }
    
    public function postRegister() {
        
        $validator = $this->registerValidator(Input::all());
        
        if($validator->fails()) {
            return Redirect::action('Auth\AuthController@getRegister')->withErrors($validator)->withInput();
        } else {                
            $user = new User;
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->activation_code = str_random(60);
            $user->status = 1;
            $user->verify = 0;
            $user->save();

            if($user) {
                Mail::send('emails.auth.activate', [
                    'email' => $user->email,
                    'activation_code' => $user->activation_code,
                    'activation_url' => action_query('Auth\AuthController@getActivateAccount', [
                        'email' => Crypt::encrypt($user->email),
                        'code' => $user->activation_code,
                    ]),
                ], function($message) use($user) {
                    $message->to($user->email)->subject('Activate your account');
                } );
                return Redirect::action('Auth\AuthController@getLogin')->with('global', 'Your account has been created. We have sent you an email to activate your accout');	
            }
            
        }
    }
    
    public function getLogout() {
        $this->clearAPIToken();        
        Auth::logout();
        return redirect('/');
    }
    
    public function getActivateAccount() {
        try {
            if(Input::has('email') && Input::has('code')) {
                $user = User::where('email', '=', Input::get('email'))->where('status', '=', 1)->first();                            
                if( !empty($user->activation_code) && $user->activation_code == Input::has('code') ) {
                    $user->verify = 1;
                    $user->activation_code = null;
                    $user->save();
                    return Redirect::action('Auth\AuthController@getLogin')->with('global', $user->email . ' has been verified');
                }
            }
        } catch(Exception $exception) {
            
        }
        return Redirect::action('Auth\AuthController@getLogin')->with('global', 'Invalid verification link or expired account');
    }
    
    public function getEmailLogin() {
        return View::make('auth.email');
    }
    
    public function postEmailLogin() {
        $validator = Validator::make(Input::all(), [ 'email' => 'required|email|exists:users' ]);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        } else {                
            $user = User::where('email', '=', Input::get('email'))->where('status', '=', 1)->first();            
            $token = EmailLogin::firstOrNew(['email' => $user->email]);
            $token->token = str_random(60);
            $token->save();            
            if($user) {                
                Mail::send('emails.auth.login', [
                    'email' => $token->email,                    
                    'login_url' => action_query('Auth\AuthController@getEmailLoginLink', [
                        'email' => $token->email,
                        'token' => $token->token,
                    ]),
                ], function($message) use($token) {
                    $message->to($token->email)->subject('Login to your account');
                });
                return Redirect::back()->with('global', 'An sign in link has been sent to your email address');	
            }
        }
    }
    
    public function getEmailLoginLink() {
        try {
            if(Input::has('email') && Input::has('token')) {
                $email = Input::get('email');
                $token = EmailLogin::find($email);                       
                
                if( !empty($token->token) && strtotime($token->updated_at) > strtotime("-30 minutes") && $token->token == Input::get('token') ) {
                    $user = User::where('email', '=', $email)->where('status', '=', 1)->firstOrFail();   
                    $user->verify = 1;
                    $user->activation_code = null;
                    $user->save();
                    $token->token = null;
                    $token->save();
                    Auth::login($user);
                    $this->setAPIToken();
                    return redirect('/');
                }
            }
        } catch(Exception $exception) {
            
        }
        return Redirect::action('Auth\AuthController@getLogin')->with('global', 'Invalid or expired login link');
    }
    
}
