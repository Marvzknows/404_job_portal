<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_seeker_id',
        'job_listing_id',
        'status',
        'cover_letter',
        'resume',
    ];

    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class);
    }

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class);
    }
}
