<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    protected $table = 'table_status';

    public function Tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function getClosedTickets()
    {
        return $this->findOrFail(0)->Tickets()->get();
    }

    public function getActiveTickets()
    {
        return $this->findOrFail(1)->Tickets()->get();
    }

    public function getPendingTickets()
    {
        return $this->findOrFail(2)->Tickets()->get();
    }

    public function getAnsweredTickets()
    {
        return $this->findOrFail(3)->Tickets()->get();
    }
}
