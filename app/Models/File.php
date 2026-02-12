<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\JobApplication;
use App\Models\JobSeeker;
use App\Models\Employer;

class File extends Model
{
    protected $fillable = [
        'uploaded_by',
        'file_name',
        'file_path',
        'file_size',
        'url',
    ];

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'resume_id');
    }

    public function jobSeekers()
    {
        return $this->hasMany(JobSeeker::class, 'resume_id');
    }

    public function employers()
    {
        return $this->hasMany(Employer::class, 'logo_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'avatar_id');
    }
}
