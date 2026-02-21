<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'full_name' => $this->first_name . ' ' . $this->last_name,
                'role' => $this->role,
                'email' => $this->email
            ],
            'profile' => $this->formatProfile()

        ];
    }

    private function formatProfile()
    {
        if ($this->role === 'employer' && $this->employer) {
            $employer = $this->employer;
            return [
                'user_id' => $employer->user_id,
                'company_name' => $employer->company_name,
                'company_description' => $employer->company_description,
                'logo_id' => $employer->logo_id,
                'website' => $employer->website,
                'contact_email' => $employer->contact_email,
                'contact_phone' => $employer->contact_phone,
                'location' => $employer->location,
                'logo' => new FileResource($employer->logo)

            ];
        }

        if ($this->role === 'job_seeker' && $this->jobSeeker) {
            $job_seeker = $this->jobSeeker;
            return [
                "id" => $job_seeker->id,
                "user_id" => $job_seeker->user_id,
                "bio" => $job_seeker->bio,
                "portfolio" => $job_seeker->portfolio,
                "current_job_title" => $job_seeker->current_job_title,
                "resume_id" => $job_seeker->resume_id,
                "phone" => $job_seeker->phone,
                "location" => $job_seeker->location,
                "created_at" => $job_seeker->created_at,
                "updated_at" => $job_seeker->updated_at,
                "resume" => new FileResource($job_seeker->resume),
            ];
        }

        return null;
    }
}
