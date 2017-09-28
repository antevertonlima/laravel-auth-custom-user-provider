<?php
/**
 * Created by PhpStorm.
 * User: argen
 * Date: 27/09/2017
 * Time: 18:22
 */

namespace App\Auth;


use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use App\Pessoa;
use Validator; 

class UserProvider extends EloquentUserProvider
{
    
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return;
        }

        $credentials["user_name"] = $this->userNameKey($credentials["user_name"]);

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->createModel()->newQuery();

        foreach ($credentials as $key => $value) {
            if (! Str::contains($key, 'password')) {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }

    protected function userNameKey($userNameValue)
    {
        if($this->validateCpf($userNameValue))
        {
            return $this->getUserIdByPessoa('cpf', preg_replace('/[^0-9]/', '', $userNameValue));
        }
        else if($this->validateEmail($userNameValue))
        {
            return $this->getUserIdByPessoa('email', $userNameValue);
        }
        else
        {
            return $userNameValue;
        }
    }

    protected function validateCpf($value)
    {
        $validator = Validator::make([
            'user_name' => $value
        ], 
        [
            'user_name' => 'cpf'
        ]);

        return (!$validator->fails());
    }

    protected function validateEmail($value)
    {
        $validator = Validator::make([
            'user_name' => $value
        ], 
        [
            'user_name' => 'email'
        ]);
        
        return (!$validator->fails());
    }

    protected function getUserIdByPessoa($field, $value)
    {
        return Pessoa::where($field, '=', $value)->first()? Pessoa::where($field, '=', $value)->first()->user->user_name: null;
    }
}