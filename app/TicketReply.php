<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    protected $table = 'ticket_replies';

    public function Ticket()
    {
        return $this->belongsTo('App\Ticket');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
