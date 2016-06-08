<?php

namespace App\Http\Controllers;

use App\Node;
use App\Server;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    public function Dashboard(Request $request)
    {
        if ($request->user()->isAdmin() || $request->user()->isMod())
        {
            $data = [
                'title' => 'Admin Dashboard',
                'user' => $request->user(),
                'node' => (new Node),
                'servers' => (new Server),
                'tickets' => (new Ticket),
            ];
            return view('gentelella.admin.index', $data);
        } else
        {
            $data = [
                'title' => 'User Dashboard',
                'user' => $request->user(),
                'servers' => $request->user()->Servers(),
            ];

            return view('gentelella.servers.list', $data);
        }
    }

    public function Profile(Request $request, User $user)
    {
        if (is_null($request->route()->parameter('user')))
        {
            $data = [
                'title' => 'User Profile',
                'user' => $request->user(),
                'servers' => $request->user()->getUserServers(),
                'tickets' => $request->user()->Tickets(),
            ];
            return view('gentelella.user.profile', $data);
        } elseif ($request->user()->isAdmin() || $request->user()->isMod() || $request->user === $user || ($request->user()->isReseller() && $user->userReseller === $request->user()))
        {
            $data = [
                'title' => 'User Profile',
                'user' => $user,
                'servers' => $user->getUserServers(),
                'tickets' => $user->Tickets(),
            ];
            return view('gentelella.user.profile', $data);
        } else
        {
            return response('Access Denied', 401);
        }
    }
}
