<?php

namespace App\Http\Controllers\Auth;

use App\ActivationCode;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
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

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/theme/dashboard';

    protected $_model;

    protected $username = 'username';

    protected $loginView = 'gentelella.login';
    /**
     * Create a new authentication controller instance.
     *
     * @param ActivationCode| $model
     */
    public function __construct(ActivationCode $model)
    {
        $this->_model = $model;
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        (filter_var($request->username, FILTER_VALIDATE_EMAIL)) ? $this->username = 'email' : 'username';

        ($this->username === 'email') ? $request->merge(['email' => strtolower($request->username)]) : $request->merge(['username' => strtolower($request->username)]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.

        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && !$lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
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
            'name' => 'required|between:5,255',
            'username' => 'required|between:5,20|unique:users',
            'password' => 'required|between:8,20|confirmed',
            'email' => 'required|email|between:5,255|unique:users',
            'cpu' => 'required|cpu',
            'storage' => 'required|storage',
            'ram' => 'required|ram',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     * @internal param User $user
     */
    protected function create($data)
    {
        $user = $this->makeUser($data);

        $data['activation_code'] = $this->makeActivationCode($data['username']);

        return $user;
    }

    public function makeUser($data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'max_cpu' => $data['cpu'],
            'max_storage' => $data['storage'],
            'max_ram' => $data['ram'],
            'available_cpu' => $data['cpu'],
            'available_storage' => $data['storage'],
            'available_ram' => $data['ram'],
            'user_assoc' => NULL,
            'role_id' => 4,
        ]);
    }

    protected function makeActivationCode($username)
    {
        return $this->getModel()->make($username);
    }


    protected function getModel()
    {
        return $this->_model;
    }

}
