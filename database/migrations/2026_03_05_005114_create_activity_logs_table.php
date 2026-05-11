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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('job_listing_id')->nullable()->constrained('job_listings')->nullOnDelete();
            $table->foreignId('job_application_id')->nullable()->constrained('job_applications')->nullOnDelete();
            $table->enum('action', [
                // For Employers
                'JOB_CREATED',
                'JOB_VIEWED',
                'JOB_UPDATED',
                'JOB_DELETED',
                'JOB_ACCEPTED',
                'JOB_SHORTLISTED',
                'JOB_REJECTED',
                // For Applicants
                'JOB_APPLIED',
                'APPLICATION_WITHDRAWN',
                'PROFILE_UPDATED',
                'PASSWORD_CHANGED',
                'SAVED_JOB',
                'UNSAVED_JOB',
                // For Admin
                'USER_SUSPENDED',
                'PAYMENT_CONFIRMED'
            ]);
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
