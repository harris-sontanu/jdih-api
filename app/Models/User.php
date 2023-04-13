<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'phone',
        'www',
        'bio',
        'facebook',
        'twitter',
        'instagram',
        'tiktok',
        'youtube',
        'picture',
        'last_logged_in_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_logged_in_at' => 'datetime',
        'role'  => UserRoleEnum::class,
    ];

    public function status(): string
    {
        $status = 'active';
        if (is_null($this->email_verified_at)) $status = 'pending';
        if (isset($this->deleted_at)) $status = 'trash';

        return $status;
    }

    public function scopeCredential(Builder $query, array $request): void
    {
        $query->whereEmail($request['email'])
            ->orWhere('username', $request['email']);
    }
   
    public function scopeOfStatus(Builder $query, ?string $status): void
    {   
        match ($status) {
            'pending'   => $query->whereNull('deleted_at')->whereNull('email_verified_at'),
            'active'    => $query->whereNull('deleted_at')->whereNotNull('email_verified_at'),
            'trash'     => $query->onlyTrashed(),
            default     => $query->whereNull('created_at'),
        };
    }

    public function scopeSearch(Builder $query, ?string $q): void
    {
        if (isset($q)) {
            $query->where('name', 'like', $q . '%')
                ->orWhere('email', 'like', $q . '%');
        }
    }

    public function scopeFilter(Builder $query, ?object $request): void
    {           
        foreach ($request->all() as $key => $value) 
        {
            if ($key == 'status') $query->ofStatus($value);

            if ($key == 'role') {
                $role = $request->enum('role', UserRoleEnum::class);
                isset($role->value) ? $query->where('role', $role->value) : $query->whereNull('created_at');
            }

            $query->where($key, 'like', '%' . $value . '%');
        }
    }

    public function scopeSorted(Builder $query, ?string $order, ?string $sort): void
    {
        isset($order) 
            ? $query->orderBy($order, $sort) 
            : $query->latest();
    }
}
