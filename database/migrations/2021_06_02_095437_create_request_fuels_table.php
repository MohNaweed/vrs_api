<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestFuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_fuels', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('driver_id');
            $table->integer('distance_km');
            $table->string('fuel_type');
            $table->integer('fuel_quantity')->nullable();
            $table->string('fuel_price')->nullable();
            $table->unsignedInteger('gas_station_id')->nullable();
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
        Schema::dropIfExists('request_fuels');
    }
}
