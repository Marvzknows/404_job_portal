<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowEmployerProfileResource extends JsonResource
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
            'company_name' => $this->company_name,
            'company_description' => $this->company_description,
            'website' => $this->website,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'location' => $this->location,

            'logo' => new FileResource($this->whenLoaded('logo')),
            'user' => new UserResource($this->whenLoaded('user'))

        ];
    }
}
