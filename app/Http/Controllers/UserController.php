<?php

namespace App\Http\Controllers;

use App\Node;
use App\Role;
use App\Server;
use App\Ticket;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    public function Dashboard(Request $request)
    {
        if ($request->user()->isAdmin()) {
            $data = [
                'title' => 'Admin Dashboard',
                'user' => $request->user(),
                'node' => (new Node),
                'servers' => (new Server),
                'tickets' => (new Ticket),
            ];
            return view('gentelella.admin.index', $data);
        }
    }
}
