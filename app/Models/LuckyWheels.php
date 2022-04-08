<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyWheels extends Model
{
    use HasFactory;

     //campos de mutacoes de datas
     protected $hidden = [
       // 'id',
        'enabled',
        'created_at',
        'updated_at',
    ];
}
