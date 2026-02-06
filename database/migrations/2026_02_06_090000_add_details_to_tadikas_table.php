<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tadikas', function (Blueprint $table) {
            $table->string('registration_number')->after('name');
            $table->string('district')->after('address');
            $table->string('state')->after('district');
            $table->string('owner_name')->nullable()->after('email');
            $table->string('location')->nullable()->after('owner_name');
            $table->string('logo')->nullable()->after('location');

            $table->unique('registration_number', 'tadikas_registration_number_unique');
        });
    }

    public function down(): void
    {
        Schema::table('tadikas', function (Blueprint $table) {
            $table->dropUnique('tadikas_registration_number_unique');
            $table->dropColumn(['registration_number', 'district', 'state', 'owner_name', 'location', 'logo']);
        });
    }
};
