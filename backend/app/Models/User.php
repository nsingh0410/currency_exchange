<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        static::created(function ($user) {
            Log::info('User created', ['id' => $user->id, 'email' => $user->email]);
        });

        static::updated(function ($user) {
            Log::info('User updated', ['id' => $user->id, 'email' => $user->email]);
        });

        static::deleted(function ($user) {
            Log::warning('User deleted', ['id' => $user->id, 'email' => $user->email]);
        });
    }
}
