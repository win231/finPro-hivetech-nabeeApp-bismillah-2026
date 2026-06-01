<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $table = 'characters';

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'xp',
        'current_mood',
        'last_saved_date',
    ];
}
