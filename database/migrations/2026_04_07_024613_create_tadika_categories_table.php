<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Cipta jadual kategori
        Schema::create('tadika_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // 2. Masukkan (Seed) data lalai ke dalam jadual kategori
        DB::table('tadika_categories')->insert([
            ['name' => 'TADIKA', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'TASKA', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'TABIKA', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PRASEKOLAH', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PASTI', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Tambah lajur baharu ke dalam jadual 'tadikas' sedia ada
        Schema::table('tadikas', function (Blueprint $table) {
            $table->foreignId('tadika_category_id')->nullable()->constrained('tadika_categories')->nullOnDelete();
            $table->string('tadika_registered_name')->nullable()->after('tadika_name');
        });
    }

    public function down(): void
    {
        Schema::table('tadikas', function (Blueprint $table) {
            $table->dropForeign(['tadika_category_id']);
            $table->dropColumn(['tadika_category_id', 'tadika_registered_name']);
        });
        Schema::dropIfExists('tadika_categories');
    }
};;
