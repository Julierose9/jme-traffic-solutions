<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('blacklists', function (Blueprint $table) {
            $table->bigIncrements('blacklist_id');
            $table->foreignId('reg_vehicle_id')->unsigned()->constrained('registered_vehicles', 'reg_vehicle_id')->onDelete('cascade');
            $table->foreignId('own_id')->unsigned()->constrained('owners', 'own_id')->onDelete('cascade');
            $table->text('reason');
            $table->enum('blacklist_type', ['Violation-Based', 'License Suspension']);
            $table->date('date_added');
            $table->timestamp('lifted_date')->nullable();
            $table->enum('status', ['Active', 'Lifted'])->default('Active');
            $table->enum('appeal_status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blacklists');
    }
};