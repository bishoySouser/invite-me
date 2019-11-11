<?php

namespace App;

use App\Event;

use Illuminate\Database\Eloquent\Model;

class EventDate extends Model
{
    protected $fillable = [
        'event',
        'event_date'
    ];

    public function dates()
    {
        return $this->belongsTo(Event::class, 'event');
    }
}
