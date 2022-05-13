<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersScores extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'amount',
        'type',
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
