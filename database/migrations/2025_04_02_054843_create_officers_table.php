<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficersTable extends Migration
{
    public function up()
    {
        Schema::create('officers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('officer_id');
            $table->string('lname');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('rank');
            $table->string('contact_num');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('officers');
    }
}