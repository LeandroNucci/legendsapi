<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterSkins extends Model
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
        'character_id',
        'skin_id',
        'created_at',
        'updated_at',
    ];


    public function skins(){
        
        return $this->belongsTo(Skins::class, 'skin_id', 'id');
        //return $this->belongsToMany(Skins::class, 'character_skins', 'skin_id', 'id');
    }
}
