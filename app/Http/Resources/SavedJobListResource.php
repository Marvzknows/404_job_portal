<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SavedJobListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'job_listing_id' => $this->job_listing_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'job_listing' => $this->jobListing ? [
                'id' => $this->jobListing->id,
                'title' => $this->jobListing->title,
                'status' => $this->jobListing->status,
                'salary_min' => $this->jobListing->salary_min,
                'salary_max' => $this->jobListing->salary_max,
                'work_setup' => $this->jobListing->work_setup,
                'job_type' => $this->jobListing->job_type,
                'location' => $this->jobListing->location,
            ] : null,
            "employer" => [
                'id' => $this->jobListing->employer->id,
                'company_name' => $this->jobListing->employer->company_name,
            ],
            'is_applied' => $this->jobListing->jobApplications->isNotEmpty()
        ];
    }
}
