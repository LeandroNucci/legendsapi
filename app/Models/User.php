<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nickname',
        'token_google',
        'enable',
        'tag',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'email',
        'remember_token',
        'password',
        'token_google',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];

    
    //retorna todos os coins do usuário
    public function coins(){
        
        return $this->belongsToMany(Coins::class, 'coin_inventories', 'user_id', 'coin_id')->withPivot(['amount']);
    }


    public function teste(){
        return $this->hasMany(CoinInventories::class);
    }
    //retorna todos os personagens do usuário
    public function characters(){
        return $this->hasMany(CharacterInventories::class);
    }

    public function skins(){
        return $this->hasMany(CharacterSkinsInventories::class);
      //  return $this->belongsToMany(Skins::class, 'character_skins_inventories', 'user_id', 'skin_id')->withPivot(['character_id']);
    }

    public function cards(){
        return $this->belongsToMany(Character::class, 'character_cards_inventories', 'user_id', 'character_id')->withPivot(['amount']);
    }
    
}
