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
use Illuminate\Http\Request;
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
    'middleware' => ['auth'],
    'as' => 'server::',
], function () {

    Route::get('/', "ServerController@listServers");
    Route::get('display/{id}', "ServerController@serverView")->name('display');
    Route::get('{id}/power/off', "ServerController@powerOff");
    Route::get('{id}/power/on', "ServerController@powerOn");
    Route::get('{id}/power/reboot', "ServerController@reboot");
    Route::get('{id}/rdns', "ServerController@rdns");
    Route::get('{id}/rename', "ServerController@rename");
    Route::get('{id}/console', "ServerController@console");
    Route::get('{id}/delete', "ServerController@delete");

});

Route::group([
    'prefix' => 'ticket',
    'middleware' => ['auth'],
],function (){
    Route::get('/','TicketsController@lists');
    Route::get('{id}/display','TicketsController@view')->middleware('ticket.owner');
    Route::get('answered','TicketsController@answered');
    Route::get('un-answered','TicketsController@unAnswered');
    Route::get('pending','TicketsController@pending');
    Route::get('active','TicketsController@active');
    Route::get('closed','TicketsController@closed');

});


Route::get('test',function (Request $request){
    dd((new App\User)->find(2)->getUserTickets);
});