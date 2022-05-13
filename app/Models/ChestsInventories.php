<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChestsInventories extends Model
{
    use HasFactory;
    use SoftDeletes;

    //Campos que permite digitacao
    protected $fillable = [
        'user_id',
        'chest_id',
        'boosts',
        'code',
        'open_at',
    ];

    //campos de mutacao
    /*protected $casts = [
        'seconds'  => 'integer',
    ];*/

    //campos de mutacoes de datas
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'open_at',
    ];

   /* protected $appends = [
        'chest'
    ];*/

    public function chest(){

        return $this->hasOne(Chests::class, 'id', 'chest_id');
    }
}
