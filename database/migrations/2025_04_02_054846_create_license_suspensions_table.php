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
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamp('suspension_start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('suspension_end_date');
            $table->text('suspension_reason');
            $table->enum('appeal_status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->enum('suspension_status', ['Active', 'Completed'])->default('Active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('license_suspensions');
    }
}