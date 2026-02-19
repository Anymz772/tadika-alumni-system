<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_name',
        'user_email',
        'password',
        'user_role',
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
        return $this->hasOne(Alumni::class, 'user_id', 'user_id');
    }

    public function ownedTadika()
    {
        return $this->hasOne(Tadika::class, 'owner_user_id', 'user_id');
    }

    public function isAdmin()
    {
        return $this->user_role === 'admin';
    }

    public function isAlumni()
    {
        return $this->user_role === 'alumni';
    }

    public function isTadika()
    {
        return $this->user_role === 'tadika';
    }

    public function isTadikaOwner()
    {
        return $this->isTadika();
    }

    // Add this to User.php to fix Password Resets
    public function getEmailForPasswordReset()
    {
        return $this->user_email;
    }

    // Add this to User.php to fix Email Verification functionality
    public function getEmailForVerification()
    {
        return $this->user_email;
    }
}