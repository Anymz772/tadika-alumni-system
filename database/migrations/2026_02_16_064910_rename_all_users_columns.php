<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAllUsersColumns extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id', 'user_id');
            $table->renameColumn('name', 'user_name');
            $table->renameColumn('email', 'user_email');
            $table->renameColumn('role', 'user_role');
            // Keep other columns as they are
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('user_id', 'id');
            $table->renameColumn('user_name', 'name');
            $table->renameColumn('user_email', 'email');
            $table->renameColumn('user_role', 'role');
        });
    }
}