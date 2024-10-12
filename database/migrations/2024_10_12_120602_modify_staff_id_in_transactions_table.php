<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStaffIdInTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Change staff_id to varchar
            $table->string('staff_id')->change();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Roll back to bigint if necessary
            $table->bigInteger('staff_id')->unsigned()->change();
        });
    }
}
