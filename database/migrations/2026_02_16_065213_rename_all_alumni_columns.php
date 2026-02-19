<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAllAlumniColumns extends Migration
{
    public function up()
    {
        Schema::table('alumni', function (Blueprint $table) {
            // Primary key
            $table->renameColumn('id', 'alumni_id');
            
            // Foreign keys (keep names)
            // user_id stays as user_id
            // tadika_id stays as tadika_id
            
            // Personal info
            $table->renameColumn('full_name', 'alumni_name');
            $table->renameColumn('ic_number', 'alumni_ic');
            $table->renameColumn('gender', 'gender');
            $table->renameColumn('age', 'age');
            $table->renameColumn('address', 'alumni_address');
            $table->renameColumn('contact_number', 'alumni_phone');
            $table->renameColumn('email', 'alumni_email');
            $table->renameColumn('photo', 'alumni_photo');
            
            // Education/Work
            $table->renameColumn('grad_year', 'grad_year');
            $table->renameColumn('current_status', 'alumni_status');
            $table->renameColumn('institution_name', 'institution');
            $table->renameColumn('company_name', 'company');
            $table->renameColumn('current_workplace', 'workplace');
            $table->renameColumn('job_position', 'job_position');
            
            // Location
            $table->renameColumn('state', 'alumni_state');
            $table->renameColumn('tadika_name', 'tadika_name');
            
            // Parents
            $table->renameColumn('father_name', 'father_name');
            $table->renameColumn('mother_name', 'mother_name');
            $table->renameColumn('parent_contact', 'parent_phone');
            
            // Timestamps stay the same
        });
    }

    public function down()
    {
        Schema::table('alumni', function (Blueprint $table) {
            // Revert all changes
            $table->renameColumn('alumni_id', 'id');
            
            $table->renameColumn('alumni_name', 'full_name');
            $table->renameColumn('alumni_ic', 'ic_number');
            $table->renameColumn('gender', 'gender');
            $table->renameColumn('age', 'age');
            $table->renameColumn('alumni_address', 'address');
            $table->renameColumn('alumni_phone', 'contact_number');
            $table->renameColumn('alumni_email', 'email');
            $table->renameColumn('alumni_photo', 'photo');
            
            $table->renameColumn('grad_year', 'grad_year');
            $table->renameColumn('alumni_status', 'current_status');
            $table->renameColumn('institution', 'institution_name');
            $table->renameColumn('company', 'company_name');
            $table->renameColumn('workplace', 'current_workplace');
            $table->renameColumn('job_position', 'job_position');
            
            $table->renameColumn('alumni_state', 'state');
            $table->renameColumn('tadika_name', 'tadika_name');
            
            $table->renameColumn('father_name', 'father_name');
            $table->renameColumn('mother_name', 'mother_name');
            $table->renameColumn('parent_phone', 'parent_contact');
        });
    }
}