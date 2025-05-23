<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('report_id');
            $table->foreignId('violation_id')->constrained('violations', 'violation_id')->onDelete('cascade');
            $table->foreignId('officer_id')->constrained('officers', 'officer_id')->onDelete('cascade');
            $table->foreignId('reg_vehicle_id')->constrained('registered_vehicles', 'reg_vehicle_id')->onDelete('cascade');
            $table->foreignId('own_id')->constrained('owners', 'own_id')->onDelete('cascade');
            $table->text('report_details');
            $table->string('location');
            $table->date('report_date');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
}