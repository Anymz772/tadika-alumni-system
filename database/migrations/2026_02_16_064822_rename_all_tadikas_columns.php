<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAllTadikasColumns extends Migration
{
    public function up()
    {
        Schema::table('tadikas', function (Blueprint $table) {
            $table->renameColumn('id', 'tadika_id');
            $table->renameColumn('name', 'tadika_name');
            $table->renameColumn('registration_number', 'tadika_reg_no');
            $table->renameColumn('address', 'tadika_address');
            $table->renameColumn('district', 'tadika_district');
            $table->renameColumn('state', 'tadika_state');
            $table->renameColumn('phone', 'tadika_phone');
            $table->renameColumn('email', 'tadika_email');
            $table->renameColumn('owner_name', 'tadika_owner');
            $table->renameColumn('location', 'tadika_location');
            $table->renameColumn('logo', 'tadika_logo');
        });
    }

    public function down()
    {
        Schema::table('tadikas', function (Blueprint $table) {
            $table->renameColumn('tadika_id', 'id');
            $table->renameColumn('tadika_name', 'name');
            $table->renameColumn('tadika_reg_no', 'registration_number');
            $table->renameColumn('tadika_address', 'address');
            $table->renameColumn('tadika_district', 'district');
            $table->renameColumn('tadika_state', 'state');
            $table->renameColumn('tadika_phone', 'phone');
            $table->renameColumn('tadika_email', 'email');
            $table->renameColumn('tadika_owner', 'owner_name');
            $table->renameColumn('tadika_location', 'location');
            $table->renameColumn('tadika_logo', 'logo');
        });
    }
}