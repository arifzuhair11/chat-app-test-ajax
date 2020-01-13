<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function messages()
    {
        return $this->hasMany(Messages::class, 'receiver_id');
    }

    public static function generateInitials($name)
    {
      $word = explode(' ', $name);
      if(count($word) >= 2){
        return strtoupper(substr($word[0], 0, 1) . substr(end($word), 0, 1));
      }
      User::makeInitialsFromSingleName($name);
    }

    protected static function makeInitialsFromSingleName($name)
    {
      preg_match_all('#([A-Z]+)#', $name, $capitals);
        if (count($capitals[1]) >= 2) {
            return substr(implode('', $capitals[1]), 0, 2);
        }
        return strtoupper(substr($name, 0, 2));
    }
}
