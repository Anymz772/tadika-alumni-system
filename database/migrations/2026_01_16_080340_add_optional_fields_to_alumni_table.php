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
        Schema::table('alumni', function (Blueprint $table) {
            $table->string('state')->nullable()->after('contact_number');
            $table->string('tadika_name')->nullable()->after('state');
            $table->enum('gender', ['male', 'female'])->nullable()->after('tadika_name');
            $table->integer('age')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->dropColumn(['state', 'tadika_name', 'gender', 'age']);
        });
    }
};
