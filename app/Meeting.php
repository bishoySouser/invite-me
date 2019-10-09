<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
            'owner_id', 'invitee_id', 'subject',
            'description', 'date_meeting', 'start_time', 'finish_time'
    ];
    // A meeting belongs to a owner 
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    // A meeting also belongs to a invitee
    public function invitee()
    {
        return $this->belongsTo(User::class, 'invitee_id');
    }
}
