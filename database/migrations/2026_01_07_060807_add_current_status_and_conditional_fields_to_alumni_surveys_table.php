<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('alumni_surveys', function (Blueprint $table) {
            $table->enum('current_status', ['studying', 'working'])->after('contact_number');
            $table->string('institution_name')->nullable()->after('current_status');
            $table->string('company_name')->nullable()->after('institution_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumni_surveys', function (Blueprint $table) {
            $table->dropColumn(['current_status', 'institution_name', 'company_name']);
        });
    }
};
