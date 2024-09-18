<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->decimal('latitude', 10, 8); // Store latitude for the map
            $table->decimal('longitude', 11, 8); // Store longitude for the map
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('branches');
    }

};
