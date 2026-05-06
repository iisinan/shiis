<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nomination extends Model
{
    protected $fillable = [
        'nominator_id',
        'nominee_id',
        'position',
        'reason',
        'status',
    ];

    public function nominator()
    {
        return $this->belongsTo(User::class, 'nominator_id');
    }

    public function nominee()
    {
        return $this->belongsTo(User::class, 'nominee_id');
    }
}
