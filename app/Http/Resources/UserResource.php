<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        return [
            'id'        => (string)$this->id,
            'name'      => $this->name,
            'username'  => $this->username,
            'picture'   => $this->picture,
            'role'      => $this->role,
            'email'     => $this->email,
            'emailVerifiedAt'   => $this->email_verified_at,
            'phone'     => $this->phone,
            'bio'       => $this->bio,
            'www'       => $this->www,
            'facebook'  => $this->facebook,
            'twitter'   => $this->twitter,
            'tiktok'    => $this->tiktok,
            'instagram' => $this->instagram,
            'youtube'   => $this->youtube,
            'deletedAt' => $this->deleted_at,
            'rememberToken' => $this->remember_token,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
