<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nickname',
        'gender',
        'phone_number',
        'state_country',
        'occupation',
        'profile_photo',
        'biography',
        'year_admitted',
        'year_graduated',
        'is_paid',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_paid' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    public function nominationsMade()
    {
        return $this->hasMany(Nomination::class, 'nominator_id');
    }
    
    public function nominationsReceived()
    {
        return $this->hasMany(Nomination::class, 'nominee_id');
    }

    public function nominations()
    {
        return $this->nominationsMade();
    }
    
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
