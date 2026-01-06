<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $fillable = [
        'user_id',
        'full_name',
        'ic_number',
        'year_graduated',
        'current_workplace',
        'job_position',
        'contact_number',
        'address',
        'father_name',
        'mother_name',
        'parent_contact',
        'email',
        'photo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
