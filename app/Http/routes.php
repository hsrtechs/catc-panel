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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::group([
    'prefix' => 'make'], function () {

    Route::get('server', 'ServerController@make');
    Route::get('log', function () {
        $params = [
            'name' => 'Reboot Server',
            'desc' => 'Creating a server.',
            'data' => json_encode(['status' => 'OK', 'id' => 15346, 'data' => 'layer1']),
            'action_code' => 2701,
            'status' => 'OK',
            'type' => 2,
        ];
        return \App\Log::make($params);
    });

    Route::get('perm', function () {
        $perms = ['Admin', 'Mod', 'Tickets', 'Profile'];
        foreach ($perms as $prem) {
            $p = new \App\Permission;
            $r[] = $p->make($prem);
        }
        return $r;
    });

    Route::get('roles', function () {
        $perms = ['Administrator','Moderator','Reseller','User','Suspended', 'Terminated'];
        foreach ($perms as $prem) {
            $p = new \App\Role;
            $r[] = $p->make($prem);
        }
        return $r;
    });

    Route::get('depart', function () {
        $perms = ['Technical'];
        foreach ($perms as $prem) {
            $p = new \App\Department;
            $r[] = $p->make($prem);
        }
        return $r;
    });

    Route::get('ticket/{num?}',function ($num = 1) {
        $f = Faker\Factory::create();
        for ($x = 1;$x <= $num; $x++){
            $t = new \App\Ticket;
            $t->title = $f->title;
            $t->ticket_status_id = 1;
            $t->department_id = 1;
            $t->user_id = 1;
            $t->desc = $f->text;

            $r[] = $t->save();
        }
        return $r;
    })->where(['num' => '[0-9]+']);

}
);


Route::get('/', function () {
    return redirect(route('theme::home'));
})->name('home');



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
    Route::post('addResources', "ServerController@addResources");
});

// Authentication Routes...
Route::get('login', 'Auth\AuthController@showLoginForm')->name('login');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\AuthController@showRegistrationForm');
//Route::post('register', 'Auth\AuthController@register');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');


Route::get('servers', "ServerController@listServers");
Route::group([
    'prefix' => 'servers',
    'middleware' => ['auth','server.owner'],
], function () {
    Route::get('build', "ServerController@build");
    Route::post('make', "ServerController@make");
    Route::get('display/{id}', "ServerController@serverView");
    Route::post('{id}/power/off', "ServerController@powerOff");
    Route::post('{id}/power/on', "ServerController@powerOn");
    Route::post('{id}/power/reboot', "ServerController@reboot");
    Route::post('{id}/rdns', "ServerController@rdns");
    Route::post('{id}/rename', "ServerController@rename");
    Route::get('{id}/console', "ServerController@console");
    Route::post('{id}/delete', "ServerController@delete");

    Route::group([
        'roles' => ['Administrator','Moderator','Reseller'],
        'middleware' => ['roles'],
    ],function (){
        Route::post('alter/{id}', "ServerController@changeServerOwnerPost");
        Route::get('alter/{id}', "ServerController@changeServerOwner");
        Route::get('addResources/{user?}', "ServerController@addResources");
        Route::post('addResources', "ServerController@addResourcesPost");
    });
});

Route::group([
    'prefix' => 'ticket',
    'middleware' => ['auth'],
],function (){
    Route::get('/','TicketsController@lists');
    Route::get('{id}/display','TicketsController@view');
    Route::get('answered','TicketsController@answered');
    Route::get('un-answered','TicketsController@unAnswered');
    Route::get('pending','TicketsController@pending');
    Route::get('active','TicketsController@active');
    Route::get('closed','TicketsController@closed');
});
Route::get('test',function (Request $r)
{
    \Session::flash('set1','neadaw set');
    if(\Session::has('set1')){
        echo \Session::get('set1');
    }
});

Route::get('log',function (){
    (\Log::getMonolog());
});