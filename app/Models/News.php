<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    //tabela
    protected $table = 'news';

    //Campos que permite digitacao
    protected $fillable = [
        'message', 
        'language_id',
        'game_id',
    ];

    //campos de mutacao
    protected $casts = [
        'message'       => 'string',
        'language_id'   => 'integer',
        'game_id'       => 'integer',
        'created_at' => 'datetime:Y-m-d',
    ];

    //campos de mutacoes de datas
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    protected $hidden = [
        'id',
        'language_id',
        //'created_at',
        'updated_at',
    ];

}
