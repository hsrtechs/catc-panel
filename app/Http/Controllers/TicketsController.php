<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

use App\Http\Requests;

class TicketsController extends Controller
{
    public function viewTicket(Request $request, Ticket $ticket)
    {
        $data = [
            'title' => 'Display #' . $ticket->id,
            'user' => $request->user(),
            'ticket' => $ticket,
        ];
        return view('gentelella.tickets.display', $data);
    }
}
