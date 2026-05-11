<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'job_listing_id',
        'job_application_id',
        'action',
        'description',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class);
    }

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}
