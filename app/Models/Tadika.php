<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tadika extends Model
{
    use HasFactory;

    protected $table = 'tadikas';
    protected $primaryKey = 'tadika_id';

    protected $fillable = [
        'tadika_name',
        'tadika_reg_no',
        'tadika_address',
        'tadika_district',
        'tadika_state',
        'tadika_postcode',
        'tadika_phone',
        'tadika_email',
        'tadika_logo',
        'tadika_owner',
        'tadika_location',
        'owner_user_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id', 'user_id');
    }

    public function alumni()
    {
        return $this->hasMany(Alumni::class, 'tadika_id', 'tadika_id');
    }
}
