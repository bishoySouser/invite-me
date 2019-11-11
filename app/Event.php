<?php

namespace App;

use App\EventDate;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'event_start',
        'event_end',
        'event_date',
        'edit'
    ];

    public function event()
    {
        return $this->hasMany(EventDate::class, 'event');
    }
}
