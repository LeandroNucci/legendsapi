<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinInventories extends Model
{
    //Campos que permite digitacao
    protected $fillable = [
        'coin_id', 
        'user_id', 
        'amount',
    ];

    //campos de mutacoes de datas
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    use HasFactory;
}
