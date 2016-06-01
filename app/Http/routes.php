<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use \App\Log;
use Illuminate\Support\Facades\Auth;

Route::group([
    'prefix' => 'make'], function () {

    Route::get('server', 'serverController@make');
    Route::get('log', function () {
        $params = [
            'name' => 'Reboot Server',
            'desc' => 'Creating a server.',
            'data' => json_encode(['status' => 'OK', 'id' => 15346, 'data' => 'layer1']),
            'action_code' => 2701,
            'status' => 'OK',
            'type' => 2,
        ];
        return Log::make($params);
    });

    Route::get('perm', function () {
        $perms = ['Admin', 'Mod'];
        foreach ($perms as $prem) {
            $p = new \App\Permission();
            $r[] = $p->make($prem);
        }
        return $r;
    });

    Route::get('roles', function () {
        $perms = ['Suspended', 'Terminated'];
        foreach ($perms as $prem) {
            $p = new \App\Role();
            $p->make($prem);
        }
    });

}
);


Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index');

});

Route::group([
    'prefix' => 'theme',
    'middleware' => 'auth',
    'as' => 'theme::',
], function () {

    Route::get('dashboard', 'UserController@Dashboard')->name('home');

    Route::get('profile/{user?}', 'UserController@Profile');

    Route::get('settings', function () {
        return view('gentelella.index', ['user' => Auth::user()]);
    })->name('settings');

    Route::get('login', function () {
        return view('gentelella.index', ['user' => Auth::user()]);
    })->name('login');

});

// Authentication Routes...
Route::get('login', 'Auth\AuthController@showLoginForm')->name('login');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\AuthController@showRegistrationForm');
Route::post('register', 'Auth\AuthController@register');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');


Route::group([
    'prefix' => 'servers',
    'middleware' => ['auth', 'server.owner'],
    'as' => 'server::',
], function () {

    Route::get('display/{id}', "ServerController@serverView")->name('display')->where(['id' => '[0-9]+']);
    Route::get('lists', "ServerController@listServers")->name('lists');
    Route::get('{id}/power/off', "ServerController@powerOff");
    Route::get('{id}/power/on', "ServerController@powerOn");
    Route::get('{id}/power/reboot', "ServerController@reboot");
    Route::get('{id}/rdns', "ServerController@rdns");
    Route::get('{id}/rename', "ServerController@rename");
    Route::get('{id}/console', "ServerController@console");
    Route::get('{id}/delete', "ServerController@delete");

});
