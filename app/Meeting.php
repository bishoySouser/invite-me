<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
            'meeting_owner', 'invitee', 'subject',
            'description', 'meeting_data', 'start_time',
            'finish_time', 'long', 'lat',
    ];
}
