<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniSurvey extends Model
{
    use HasFactory;

    protected $table = 'alumni_surveys';

    protected $fillable = [
        'full_name',
        'ic_number',
        'year_graduated',
        'email',
        'contact_number',
        'current_workplace',
        'job_position',
        'address',
        'father_name',
        'mother_name',
        'parent_contact',
        'status',
        'admin_notes'
    ];

    protected $casts = [
        'year_graduated' => 'integer',
    ];

    // Scope for pending surveys
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for approved surveys
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope for rejected surveys
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}