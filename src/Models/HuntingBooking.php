<?php

namespace Older777\GosIdea\Models;

use Illuminate\Database\Eloquent\Model;

class HuntingBooking extends Model
{
    protected $fillable = [
        'tour_name',
        'hunter_name',
        'guide_id',
        'date',
        'participants_count',
    ];
}
