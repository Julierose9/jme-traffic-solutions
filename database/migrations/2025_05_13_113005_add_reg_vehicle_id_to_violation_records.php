<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('violation_records', function (Blueprint $table) {
            $table->foreignId('reg_vehicle_id')->after('record_id')->constrained('registered_vehicles', 'reg_vehicle_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('violation_records', function (Blueprint $table) {
            $table->dropForeign(['reg_vehicle_id']);
            $table->dropColumn('reg_vehicle_id');
        });
    }
};
