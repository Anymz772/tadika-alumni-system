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
        'tadika_id',
        'full_name',
        'ic_number',
        'year_graduated',
        'current_status',
        'institution_name',
        'company_name',
        'job_position',
        'contact_number',
        'address',
        'father_name',
        'mother_name',
        'parent_contact',
        'email',
        'photo',
        'state',
        'tadika_name',
        'gender',
        'age'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tadika()
    {
        return $this->belongsTo(Tadika::class);
    }
}
