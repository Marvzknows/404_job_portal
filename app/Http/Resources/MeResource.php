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
                'logo' => $employer->logo ? [
                    'id' => $employer->logo->id,
                    'file_name' => $employer->logo->file_name,
                    'file_path' => $employer->logo->file_path,
                    'url' => $employer->logo->url,
                    'uploaded_by' => $employer->logo->uploadedBy ? [
                        'id' => $employer->logo->uploadedBy->id,
                        'full_name' => $employer->logo->uploadedBy->first_name . ' ' . $employer->logo->uploadedBy->last_name,
                        'email' => $employer->logo->uploadedBy->email,
                    ] : null,
                ] : null,

            ];
        }

        if ($this->role === 'job_seeker' && $this->jobSeeker) {
            return [
                'type' => 'job_seeker',
                'data' => [
                    'id' => $this->jobSeeker->id,
                    'bio' => $this->jobSeeker->bio,
                    'portfolio' => $this->jobSeeker->portfolio,
                    'current_job_title' => $this->jobSeeker->current_job_title,
                    'phone' => $this->jobSeeker->phone,
                    'location' => $this->jobSeeker->location,
                    'resume_id' => $this->jobSeeker->resume_id,
                ],
            ];
        }

        return null;
    }
}
