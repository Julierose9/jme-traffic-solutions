<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViolationsTable extends Migration
{
    public function up()
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('violation_id');
            $table->string('violation_code')->unique();
            $table->text('description');
            $table->decimal('penalty_amount', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('violations');
    }
}