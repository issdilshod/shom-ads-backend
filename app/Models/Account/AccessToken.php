<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'ip',
        'device',
        'expired_at',
        'deleted_at'
    ];

}
