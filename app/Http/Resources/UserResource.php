<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'account_status' => $this->account_status,
            'avatar_url' => $this->avatar_url,
            'bio' => $this->bio,
            'timezone' => $this->timezone,
            'language' => $this->language,
            'skills' => $this->skills,
            'profile_visibility' => $this->profile_visibility,
            'email_verified' => !is_null($this->email_verified_at),
            'email_verified_at' => $this->email_verified_at?->toISOString(),
            'two_factor_enabled' => $this->two_factor_enabled,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
