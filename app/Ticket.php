<?php

namespace App;

use App\TicketStatus;
use Hamcrest\Type\IsInteger;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    public function make(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this->saveOrFail();
    }

    // Relationships

    public function Replies()
    {
        return $this->hasMany('App\TicketReply');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    public function Closed()
    {
        return $this->all()->where('ticket_status_id', 0)->count();
    }

    public function Active()
    {
        return $this->all()->where('ticket_status_id', 1)->count();
    }

    public function Pending()
    {
        return $this->all()->where('ticket_status_id', 2)->count();
    }

    public function Answered()
    {
        return $this->all()->where('ticket_status_id', 3)->count();
    }
}
