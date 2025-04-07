<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('payment_id');
            $table->foreignId('record_id')->constrained('violation_records', 'record_id')->onDelete('cascade');
            $table->date('payment_date');
            $table->string('payment_method');
            $table->string('transaction_reference')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}