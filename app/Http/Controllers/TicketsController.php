<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

use App\Http\Requests;

class TicketsController extends Controller
{

    public function lists(Request $request)
    {
        $data = [
            'title' => 'List Tickets',
            'user' => $request->user(),
            'tickets' => $request->user()->Tickets(),
        ];
        return view('gentelella.tickets.list',$data);
    }

    public function view(Request $request, Ticket $id)
    {
        $data = [
            'title' => 'Display #' . $id->id,
            'user' => $request->user(),
            'ticket' => $id,
        ];
        return view('gentelella.tickets.display', $data);
    }

    public function active(Request $request){
        $data = [
            'title' => 'List Tickets',
            'user' => $request->user(),
            'tickets' => $request->user()->Tickets()->whereIn('ticket_status_id',[1,2,3]),
        ];
        return view('gentelella.tickets.list',$data);
    }
    public function unAnswered(Request $request){
        $data = [
            'title' => 'List Tickets',
            'user' => $request->user(),
            'tickets' => $request->user()->Tickets()->where('ticket_status_id',1),
        ];
        return view('gentelella.tickets.list',$data);
    }
    public function closed(Request $request){
        $data = [
            'title' => 'List Tickets',
            'user' => $request->user(),
            'tickets' => $request->user()->Tickets()->where('ticket_status_id',0),
        ];
        return view('gentelella.tickets.list',$data);
    }
    public function answered(Request $request){
        $data = [
            'title' => 'List Tickets',
            'user' => $request->user(),
            'tickets' => $request->user()->Tickets()->where('ticket_status_id',3),
        ];
        return view('gentelella.tickets.list',$data);
    }
    public function pending(Request $request){
        $data = [
            'title' => 'List Tickets',
            'user' => $request->user(),
            'tickets' => $request->user()->Tickets()->where('ticket_status_id',2),
        ];
        return view('gentelella.tickets.list',$data);
    }
}
