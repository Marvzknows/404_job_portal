<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\JobListing;
use App\Models\File;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employer extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'company_name',
        'company_description',
        'logo_id',
        'website',
        'contact_email',
        'contact_phone',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class);
    }
    public function logo()
    {
        return $this->belongsTo(File::class, 'logo_id');
    }
}
