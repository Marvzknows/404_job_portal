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
            'job_listing' => new ShowJobListingListResource($this->whenLoaded('jobListing')),
            'is_applied' => $this->jobListing->jobApplications->isNotEmpty()
        ];
    }
}
