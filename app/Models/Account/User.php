<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password',
        'phone',
        'phone_verified_at',
        'email',
        'email_verified_at',
        'last_seen',
        'status',
        'deleted_at'
    ];

    protected $hidden = [
        'password'
    ];
}
