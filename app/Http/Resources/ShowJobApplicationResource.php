<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowJobApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'status'       => $this->status,
            'cover_letter' => $this->cover_letter,
            'applied_at'  => $this->created_at?->toDateTimeString(),

            'job_seeker' => [
                'id'        => $this->jobSeeker?->id,
                'bio'       => $this->jobSeeker?->bio,
                'portfolio' => $this->jobSeeker?->portfolio,
                'job_title' => $this->jobSeeker?->current_job_title,
                'phone'     => $this->jobSeeker?->phone,
                'location'  => $this->jobSeeker?->location,
                'user'      => new UserResource($this->jobSeeker?->user),
            ],

            'job_listing' => [
                'id'          => $this->jobListing?->id,
                'title'       => $this->jobListing?->title,
                'status'      => $this->jobListing?->status,
                'salary_min' => $this->jobListing?->salary_min,
                'salary_max' => $this->jobListing?->salary_max,
                'work_setup' => $this->jobListing?->work_setup,
                'job_type'   => $this->jobListing?->job_type,
                'employer'   => [
                    'id' => $this->jobListing->employer?->id,
                    'company_name' => $this->jobListing->employer?->company_name,
                    'company_description' => $this->jobListing->employer?->company_description,
                    'website' => $this->jobListing->employer?->website,
                    'contact_email' => $this->jobListing->employer?->contact_email,
                    'contact_phone' => $this->jobListing->employer?->contact_phone,
                    'location' => $this->jobListing->employer?->location,
                ]
            ],
        ];
    }
}
