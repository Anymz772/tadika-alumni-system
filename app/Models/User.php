<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_login_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime'
    ];

    public function alumni()
    {
        return $this->hasOne(Alumni::class);
    }

    public function ownedTadika()
    {
        return $this->hasOne(Tadika::class, 'owner_user_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAlumni()
    {
        return $this->role === 'alumni';
    }

    public function isTadika()
    {
        return $this->role === 'tadika';
    }

    public function isTadikaOwner()
    {
        return $this->isTadika();
    }
}
