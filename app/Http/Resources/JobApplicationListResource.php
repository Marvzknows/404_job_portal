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
            "job_listing" => [
                "id" => $this->jobListing->id,
                "title" => $this->jobListing->title,
            ],
            "job_seeker" => [
                "id" => $this->jobSeeker->id,
                "full_name" => $this->jobSeeker->user->full_name,
            ]
        ];
    }
}
