<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->morphs('payable'); // This will create payable_type and payable_id for both violation records and reports
            $table->dateTime('payment_date');
            $table->string('payment_method');
            $table->string('transaction_reference');
            $table->decimal('amount_paid', 10, 2);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}; 