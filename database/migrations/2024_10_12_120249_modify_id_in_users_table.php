<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyIdInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Change id to varchar
            $table->string('id')->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Roll back to bigint if necessary
            $table->bigInteger('id')->unsigned()->change();
        });
    }
}

