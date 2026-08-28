<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
protected $fillable = [
    'name',
    'email',
    'phone',
    'password',
    'gender',
    'interested_in',
    'age',
    'latitude',
    'longitude',
    'city',
    'country',
    'avatar',
    'deactivated_at',
    'is_deactivated',
    'is_featured',
    'profile_complete',
    'subscription_plan',
    'is_admin',
];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'deactivated_at' => 'datetime',
            'is_deactivated' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }
    public function photos()
{
    return $this->hasMany(Photo::class)->orderBy('position');
}
}
