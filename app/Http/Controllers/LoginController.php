<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(){
        $login_data = request(['email', 'password']);

        $validator = Validator::make($login_data, [
            'email' => 'required|email',
            'password' => 'required|min:8|max:32'
        ],
            [
                'email.required' => 'Введите почту!',
                'email.email' => 'Почта не валидна!',
                'password.required' => 'Введите пароль!',
                'password.max' => 'Пароль длиннее 32 символов!',
                'password.min' => 'Пароль короче 8 символов!',
            ]
        );

        if($validator->fails()){
            return response()->json(["success"=>false, 'errors'=>$validator->errors()]);
        }

        $user = User::where('email', request('email'))->first();
        if($user === null){
            return response()->json(["success"=>false,"errors"=>["email"=>"Пользователя не существует!"]]);
        }
        if(!Hash::check(request('password'),$user->password)){
            return response()->json(["success"=>false,"errors"=>["password"=>"Неверный пароль!"]]);
        }
        $user->updateToken();
        return response()->json(["success"=>true,"data"=>["token"=>$user->token,"name" => $user->name,"money"=>$user->money]]);
    }
}
