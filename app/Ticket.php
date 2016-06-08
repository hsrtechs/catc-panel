<?php

namespace App;

use App\TicketStatus;
use Hamcrest\Type\IsInteger;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'department_id' => 'int',
        'ticket_status_id' => 'int',
        'title' => 'string',
        'desc' => 'string',
        'status' => 'string',
    ];

    protected $appends = ['status'];

    public function make(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this->saveOrFail();
    }

    public function getStatusClass(){
        switch($this->ticket_status_id){
            case 0 : return 'bg-green';break;
            case 1 : return 'bg-orange';break;
            case 2 : return 'bg-red';break;
            case 3 : return 'bg-green';break;
        }
    }

    /**
     * Relationships
    */
    public function Replies()
    {
        return $this->hasMany('App\TicketReply');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Attribute Accessors
     */

    public function getStatusAttribute(){
        switch($this->ticket_status_id){
            case 0 : return 'Closed';break;
            case 1 : return 'Active';break;
            case 2 : return 'Pending';break;
            case 3 : return 'Answered';break;
        }
    }

    public function getIdAttribute($value){
        return $value;
    }

    /**
     * Tickets Counting
    */

    public function ClosedCount()
    {
        return $this->all()->where('ticket_status_id', 0)->count();
    }

    public function ActiveCount()
    {
        return $this->all()->where('ticket_status_id', 1)->count();
    }

    public function PendingCount()
    {
        return $this->all()->where('ticket_status_id', 2)->count();
    }

    public function AnsweredCount()
    {
        return $this->all()->where('ticket_status_id',3)->count();
    }

    /**
     * Query Scopes
     */

    public static function scopeActiveTickets(){
        return self::all()->whereIn('ticket_status_id',[1,2,3]);
    }
}
