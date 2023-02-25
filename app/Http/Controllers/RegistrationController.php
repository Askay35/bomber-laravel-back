<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function store(){
        $reg_data = request(['email', 'password']);

        $validator = Validator::make($reg_data, [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:32'
        ],
            [
                'email.required' => 'Введите почту!',
                'email.email' => 'Почта не валидна!',
                'email.unique' => 'Почта занята!',
                'password.required' => 'Введите пароль!',
                'password.max' => 'Пароль длиннее 32 символов!',
                'password.min' => 'Пароль короче 8 символов!',
            ]
        );

        if($validator->fails()){
            return response()->json(["success"=>false]);
        }

        $reg_data['password']=Hash::make($reg_data['password']);

        $user = User::create($reg_data);

        $user->name = 'user' . rand(100000,9999999).str_pad($user->id, 3, STR_PAD_LEFT);
        $user->updateToken();

        return response()->json(["success"=>true,"data"=>["token"=>$user->token, "name" => $user->name]]);
    }
}
