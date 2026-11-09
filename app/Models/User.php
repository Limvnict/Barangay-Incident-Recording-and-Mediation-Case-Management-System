<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];

    public function isOfficial(): bool
    {
        return $this->role === 'official';
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    public function notices()
    {
        return $this->hasMany(Notice::class);
    }
}