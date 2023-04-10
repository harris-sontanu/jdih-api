<?php

namespace App\Http\Requests;

use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Arr;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'      => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string', 'min:6'],
            'picture'   => ['nullable', 'image', 'max:2048'],
            'email'     => ['required', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'confirmed', Password::defaults()],
            'role'      => ['required', new Enum(UserRoleEnum::class)],
            'phone'     => ['nullable', 'string'],
            'www'       => ['nullable', 'url'],
            'bio'       => ['nullable', 'string'],
            'facebook'  => ['nullable', 'url'],
            'twitter'   => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'tiktok'    => ['nullable', 'url'],
            'youtube'   => ['nullable', 'url'],
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['email'] = [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($this->route('user'))
                ];
                $rules = Arr::except($rules, ['password']);
                break;
        }

        return $rules;
    }
}
