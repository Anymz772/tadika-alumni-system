<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';
    protected $primaryKey = 'alumni_id';  // was 'id'

    protected $fillable = [
        'user_id',                       // stays the same (FK)
        'tadika_id',                      // stays the same (FK)
        'alumni_name',                     // was 'full_name'
        'alumni_ic',                       // was 'ic_number'
        'grad_year',                       // was 'grad_year'
        'alumni_status',                   // was 'current_status'
        'institution',                     // was 'institution_name'
        'company',                         // was 'company_name'
        'job_position',                    // was 'job_position' (kept same)
        'alumni_phone',                     // was 'contact_number'
        'alumni_address',                   // was 'address'
        'father_name',                      // stays the same
        'mother_name',                      // stays the same
        'parent_phone',                     // was 'parent_contact'
        'alumni_email',                     // was 'email'
        'alumni_photo',                     // was 'photo'
        'alumni_state',                     // was 'state'
        'tadika_name',                      // stays the same
        'gender',                           // stays the same
        'age'                               // stays the same
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function tadika()
    {
        return $this->belongsTo(Tadika::class, 'tadika_id', 'tadika_id');
    }
}
