<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameVersions extends Model
{
    use HasFactory;

    protected $hidden = [
        'id',
        'description',
        'created_at',
        'updated_at',
    ];
}
