<?php

namespace App\Models\Ad;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'belong_id',
        'name',
        'parent_id',
        'deleted_at'
    ];
}
