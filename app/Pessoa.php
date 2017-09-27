<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = 'pessoas';

    protected $fillable = [
    	'nome', 'sobrenome', 'email', 'cpf'
    ];

    public function user()
    {
    	return $this->hasOne(User::class);
    }

}
