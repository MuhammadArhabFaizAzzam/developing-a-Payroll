<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('desired_department')->nullable()->after('role');
            $table->string('desired_job')->nullable()->after('desired_department');
            $table->string('desired_job_status')->nullable()->after('desired_job');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'desired_department',
                'desired_job',
                'desired_job_status',
            ]);
        });
    }
};
