<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('role', 'tadika_owner')->update(['role' => 'tadika']);
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','alumni','tadika') DEFAULT 'alumni'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','alumni','tadika_owner') DEFAULT 'alumni'");
        DB::table('users')->where('role', 'tadika')->update(['role' => 'tadika_owner']);
    }
};
