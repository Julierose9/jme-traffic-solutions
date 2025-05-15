<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Ensure InnoDB for foreign key support
            $table->id(); // UserID (Primary Key)
            $table->string('username')->unique(); // Username
            $table->string('lname'); // LName
            $table->string('fname'); // FName
            $table->string('mname')->nullable(); // MName (nullable)
            $table->string('email')->unique(); // Email
            $table->string('role')->default('guest'); // Role (default: 'guest')
            $table->timestamp('email_verified_at')->nullable(); // For email verification
            $table->string('password'); // Password
            $table->rememberToken(); // For "Remember Me" functionality
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}