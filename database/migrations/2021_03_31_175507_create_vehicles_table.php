<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_no');
            $table->string('model')->nullable();
            $table->string('color')->nullable();
            $table->string('plate')->nullable();
            $table->string('chassis_no')->nullable();
            $table->string('type')->nullable();
            $table->string('branch_no')->nullable();
            $table->string('province')->nullable();
            $table->unsignedInteger('driver_id');
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
