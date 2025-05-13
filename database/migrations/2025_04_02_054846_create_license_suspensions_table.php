<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicenseSuspensionsTable extends Migration
{
    public function up()
    {
        Schema::create('license_suspensions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('suspension_id');
            $table->foreignId('own_id')->constrained('owners', 'own_id')->onDelete('cascade');
            $table->date('suspension_start_date');
            $table->date('suspension_end_date')->nullable();
            $table->text('suspension_reason');
            $table->enum('suspension_status', ['Active', 'Lifted'])->default('Active');
            $table->enum('appeal_status', ['Pending', 'Approved', 'Rejected'])->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('license_suspensions');
    }
}