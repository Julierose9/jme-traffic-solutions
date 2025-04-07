<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisteredVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('registered_vehicles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('reg_vehicle_id');
            $table->foreignId('own_id')->constrained('owners', 'own_id')->onDelete('cascade');
            $table->string('plate_number')->unique();
            $table->string('vehicle_type');
            $table->string('brand');
            $table->string('model');
            $table->string('color');
            $table->date('registration_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registered_vehicles');
    }
}