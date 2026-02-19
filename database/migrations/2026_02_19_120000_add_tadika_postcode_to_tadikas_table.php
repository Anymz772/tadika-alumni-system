<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('tadikas', 'tadika_postcode')) {
            Schema::table('tadikas', function (Blueprint $table) {
                $table->string('tadika_postcode', 50)->nullable()->after('tadika_state');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tadikas', 'tadika_postcode')) {
            Schema::table('tadikas', function (Blueprint $table) {
                $table->dropColumn('tadika_postcode');
            });
        }
    }
};
