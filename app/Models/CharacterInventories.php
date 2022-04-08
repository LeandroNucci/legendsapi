<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterInventories extends Model
{
    use HasFactory;

     //Campos que permite digitacao
     protected $fillable = [
        'user_id', 
        'character_id',
    ];

    //campos de mutacoes de datas
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    //campos de mutacoes de datas
    protected $hidden = [
        'id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function skins(){
        
        return $this->hasMany(CharacterSkinsInventories::class);
    }
}
