<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterCardsInventories extends Model
{
    use HasFactory;

    //Campos que permite digitacao
    protected $fillable = [
        'user_id', 
        'character_id',
        'amount'
    ];

    protected $hidden = [
        'id',
        'user_id',
        'created_at',
        'updated_at',
    ];

}
