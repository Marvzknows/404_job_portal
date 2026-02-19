<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JobListing;
use App\Models\JobSeeker;
use App\Models\File;

class JobApplication extends Model
{
    protected $fillable = [
        'job_seeker_id',
        'job_listing_id',
        'status',
        'cover_letter',
        'resume_id',
    ];

    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class);
    }

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class);
    }

    public function resume()
    {
        return $this->belongsTo(File::class, 'resume_id');
    }
}
