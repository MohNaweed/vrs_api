<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('purpose')->nullable();
            $table->string('passenger_name')->nullable();
            $table->string('passenger_contact')->nullable();
            $table->string('comment')->nullable();
            $table->string('status')->nullable(); // , pending, deny
            $table->string('travel_time');
            $table->string('return_time')->nullable();
            $table->boolean('return')->nullable();
            $table->unsignedInteger('source_id');
            $table->unsignedInteger('destination_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('driver_id')->nullable();
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
        Schema::dropIfExists('request_vehicles');
    }
}
