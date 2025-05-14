<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViolationRecordIdToReports extends Migration
{
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->foreignId('violation_record_id')->nullable()->after('status')
                  ->constrained('violation_records', 'record_id')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['violation_record_id']);
            $table->dropColumn('violation_record_id');
        });
    }
} 