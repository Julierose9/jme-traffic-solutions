<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViolationRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('violation_records', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('record_id');
            $table->foreignId('reg_vehicle_id')->constrained('registered_vehicles', 'reg_vehicle_id')->onDelete('cascade');
            $table->foreignId('officer_id')->constrained('officers', 'officer_id')->onDelete('cascade');
            $table->foreignId('violation_id')->constrained('violations', 'violation_id')->onDelete('cascade');
            $table->date('violation_date');
            $table->string('location');
            $table->text('remarks')->nullable();
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('violation_records');
    }
}