<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowJobListingListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status,
            'salary'      => [
                'min' => $this->salary_min,
                'max' => $this->salary_max,
            ],
            'work_setup'  => $this->work_setup,
            'job_type'    => $this->job_type,
            'employer'    => new ShowEmployerProfileResource($this->whenLoaded('employer')),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
