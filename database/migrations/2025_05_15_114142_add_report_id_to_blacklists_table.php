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
        Schema::table('blacklists', function (Blueprint $table) {
            $table->foreignId('report_id')->nullable()->after('blacklist_id')
                  ->constrained('reports', 'report_id')
                  ->onDelete('set null');
            $table->string('description')->nullable()->after('blacklist_type');
            $table->enum('resolution_status', ['Pending', 'Resolved'])->default('Pending')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blacklists', function (Blueprint $table) {
            $table->dropForeign(['report_id']);
            $table->dropColumn(['report_id', 'description', 'resolution_status']);
        });
    }
};
