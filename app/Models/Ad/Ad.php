<?php

namespace App\Models\Ad;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'partner_id',
        'category_id',

        'text',
        'phone1',
        'phone2',
        'day',
        'bonus',
        'price',

        'deleted_at'
    ];
}
