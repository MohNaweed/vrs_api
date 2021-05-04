<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('purpose')->nullable();
            $table->unsignedInteger('passenger_count')->nullable();
            $table->unsignedInteger('vehicle_id')->nullable();
            $table->unsignedInteger('source_location_request_id')->nullable();
            $table->unsignedInteger('destination_location_request_id')->nullable();
            $table->boolean('return')->nullbale();



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
        Schema::dropIfExists('requests');
    }
}
