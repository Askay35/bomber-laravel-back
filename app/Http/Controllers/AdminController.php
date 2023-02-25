<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $admin = Admin::where('login', $request->input('login'))->first();

        if ($admin!==null) {
            if(Hash::check($request->input('password'), $admin->password)){
                session()->regenerate();
                session(['admin' => $admin->login]);
                return redirect()->route('users');
            }
            return redirect()->route('loginPage')->withErrors(['password' => 'Неверный пароль']);
        }
        return redirect()->route('loginPage')->withErrors(['login' => 'Пользователя не существует']);

    }

    public function register(Request $request)
    {
        $register_data = request(['code', 'login', 'password']);

        $validator = Validator::make($register_data, [
            'code' => 'required',
            'login' => 'required|unique:admins',
            'password' => 'required'
        ],
            [
                'code.required' => 'Введите код!',
                'login.required' => 'Введите логин!',
                'login.unique' => 'Логин занят!',
                'password.required' => 'Введите пароль!'
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('registerPage')->withErrors($validator->errors());
        }
        if ($register_data['code'] !== 'vatikashka35') {
            return redirect()->route('registerPage')->withErrors(['code' => 'Неверный код!']);
        }

        $admin = new Admin;
        $admin->password = Hash::make($register_data['password']);
        $admin->login = $register_data['login'];
        $admin->save();

        session(['admin' => $admin->login]);

        return redirect()->route('users');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('loginPage');
    }
}
