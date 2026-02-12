<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\JobApplication;
use App\Models\File;

class JobSeeker extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'portfolio',
        'current_job_title',
        'resume_id',
        'phone',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function resume()
    {
        return $this->belongsTo(File::class, 'resume_id');
    }
}
