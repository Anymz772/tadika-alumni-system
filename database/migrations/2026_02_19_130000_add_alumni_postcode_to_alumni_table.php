<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('alumni', 'alumni_postcode')) {
            Schema::table('alumni', function (Blueprint $table) {
                $table->string('alumni_postcode', 50)->nullable()->after('alumni_address');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('alumni', 'alumni_postcode')) {
            Schema::table('alumni', function (Blueprint $table) {
                $table->dropColumn('alumni_postcode');
            });
        }
    }
};

