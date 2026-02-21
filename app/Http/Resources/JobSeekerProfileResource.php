<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobSeekerProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" =>  $this->id,
            "user_id" =>  $this->user_id,
            "bio" =>  $this->bio,
            "portfolio" =>  $this->portfolio,
            "current_job_title" =>  $this->current_job_title,
            "resume_id" =>  $this->resume_id,
            "phone" =>  $this->phone,
            "location" =>  $this->location,
            "created_at" =>  $this->created_at,
            "updated_at" =>  $this->updated_at,
            "job_applications" =>  $this->job_applications ?? [],
            "user" => new UserResource($this->whenLoaded('user')),
            "resume" => new FileResource($this->whenLoaded('resume')),
        ];
    }
}
