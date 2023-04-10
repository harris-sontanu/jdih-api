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
            'id'    => (string)$this->id,
            'name'  => $this->name,
            'username'  => $this->username,
            'picture'   => $this->picture,
            'role'  => $this->role,
            'email' => $this->email,
            'phone' => $this->phone,
            'bio'   => $this->bio,
            'www'   => $this->www,
            'facebook'  => $this->facebook,
            'twitter'   => $this->twitter,
            'tiktok'    => $this->tiktok,
            'instagram' => $this->instagram,
            'youtube'   => $this->youtube,
            'deleted_at'=> $this->deleted_at,
            'remember_token'=> $this->when(Gate::allows('isAdmin'), $this->remember_token),
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
