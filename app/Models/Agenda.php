<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'time',
        'title',
        'description',
        'location',
        'order',
    ];
}
