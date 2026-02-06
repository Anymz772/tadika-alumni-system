<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tadika extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'registration_number',
        'address',
        'district',
        'state',
        'phone',
        'email',
        'logo',
        'owner_name',
        'location',
        'owner_user_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function alumni()
    {
        return $this->hasMany(Alumni::class);
    }
}
