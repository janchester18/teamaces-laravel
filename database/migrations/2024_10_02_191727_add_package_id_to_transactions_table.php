<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPackageIdToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id')->nullable()->after('course_id'); // Add package_id

            // Adding the foreign key constraint
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null'); // Change 'set null' to 'cascade' if you want to delete the transaction when the package is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id'); // Remove package_id if rolling back
        });
    }
}
