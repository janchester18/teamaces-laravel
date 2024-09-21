<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleAndBranchIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user');  // Adding the role field with a default value
            $table->unsignedBigInteger('branch_id')->nullable();  // Nullable foreign key for the branch
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');  // Setting the foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
}

