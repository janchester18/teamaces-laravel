<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyInquiriesTableRemoveEmailUnique extends Migration
{
    public function up()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropUnique(['email']); // Drop the unique constraint on the email column
        });
    }

    public function down()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->unique('email'); // Reapply the unique constraint on the email column
        });
    }
}
