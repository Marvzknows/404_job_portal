<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JobApplication;
use App\Models\Employer;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobListing extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'status',
        'salary_min',
        'salary_max',
        'work_setup',
        'job_type',
        'location'
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }
}
