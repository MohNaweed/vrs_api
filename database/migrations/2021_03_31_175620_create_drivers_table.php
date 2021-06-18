<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedInteger('license_no')->nullable();
            $table->date('license_expiry_date')->nullable();
            $table->unsignedInteger('mobile_no')->nullable();
            $table->string('NIN')->nullable();
            $table->string('branch_no')->nullable();
            $table->string('province')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('vehicle_id')->nullable();
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
        Schema::dropIfExists('drivers');
    }
}
