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
            $table->string('purpose');
            $table->string('passenger_name');
            $table->string('passenger_contact');
            $table->time('travel_time');
            $table->time('return_time')->nullable();
            $table->boolean('return');
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
