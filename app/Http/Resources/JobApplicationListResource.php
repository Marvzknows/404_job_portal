<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "job_seeker_id" => $this->job_seeker_id,
            "job_listing_id" => $this->job_listing_id,
            "resume_id" => $this->resume_id,
            "status" => $this->status,
            "cover_letter" => $this->cover_letter,
            "date_applied" => $this->created_at,
            "job_listing" => [
                "id" => $this->jobListing->id,
                "title" => $this->jobListing->title,
                "location" => $this->jobListing->location,
            ],
            "job_seeker" => [
                "id" => $this->jobSeeker->id,
                "full_name" => $this->jobSeeker->user->full_name,
                "email" => $this->jobSeeker->user->email,
                "current_job_title" => $this->jobSeeker->current_job_title,
                "avatar_url" => $this->jobSeeker->user->avatar
            ],
        ];
    }
}
