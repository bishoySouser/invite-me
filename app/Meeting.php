<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
            'owner', 'invitee', 'subject',
            'description', 'date_meeting', 'start_time', 'finish_time'
    ];
}
