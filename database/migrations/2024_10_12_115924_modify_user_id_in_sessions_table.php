<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUserIdInSessionsTable extends Migration
{
    public function up()
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Change user_id to a string
            $table->string('user_id')->change();
        });
    }

    public function down()
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Roll back to integer type if necessary
            $table->integer('user_id')->change();
        });
    }
}
