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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('avatar_id')->references('id')->on('files')->nullOnDelete();
        });

        Schema::table('employers', function (Blueprint $table) {
            $table->foreign('logo_id')->references('id')->on('files')->nullOnDelete();
        });

        Schema::table('job_seekers', function (Blueprint $table) {
            $table->foreign('resume_id')->references('id')->on('files')->nullOnDelete();
        });

        Schema::table('job_applications', function (Blueprint $table) {
            $table->foreign('resume_id')->references('id')->on('files')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['avatar_id']);
        });

        Schema::table('employers', function (Blueprint $table) {
            $table->dropForeign(['logo_id']);
        });

        Schema::table('job_seekers', function (Blueprint $table) {
            $table->dropForeign(['resume_id']);
        });

        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropForeign(['resume_id']);
        });
    }
};
