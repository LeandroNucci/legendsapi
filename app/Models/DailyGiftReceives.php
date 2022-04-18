<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyGiftReceives extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'last_received_index',
        'date',
    ];
}
