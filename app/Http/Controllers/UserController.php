<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getInfo(Request $request)
    {
        if (!$request->exists('fields')) {
            return response()->json(["success" => true, "data" => ["name" => $request->user->name, "email" => $request->user->email, "money" => $request->user->money]]);
        } else {
            $data = [];
            if (in_array('name', $request->fields)) {
                $data['name'] = $request->user->name;
            }
            if (in_array('money', $request->fields)) {
                $data['money'] = $request->user->money;
            }
            if (in_array('email', $request->fields)) {
                $data['email'] = $request->user->email;
            }
            return response()->json(["success" => true, "data" => $data]);

        }
    }


    public function edit(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'email' => 'email|unique:users',
            'name' => 'min:3|max:20',
            'current_password' => 'min:8|max:32',
            'new_password' => 'min:8|max:32',
        ],
            [
                'email.email' => 'Почта не валидна!',
                'email.unique' => 'Почта занята!',
                'name.min' => 'Имя короче 3 символов!',
                'name.max' => 'Имя длиннее 30 символов!',
                'current_password.max' => 'Пароль длиннее 32 символов!',
                'current_password.min' => 'Пароль короче 8 символов!',
                'new_password.max' => 'Пароль длиннее 32 символов!',
                'new_password.min' => 'Пароль короче 8 символов!',
            ]
        );

        $errors = [
            "message" => "Новые данные не введены!"
        ];
        if ($validator->fails()) {
            return response()->json(["success" => false, "errors" => $validator->errors()]);
        } else {
            if (isset($request->email) && $request->email != $request->user->email) {
                $request->user->email = $request->email;
                unset($errors["message"]);
            }
            if (isset($request->name) && $request->name != $request->user->name) {
                $request->user->name = $request->name;
                unset($errors["message"]);
            }
            if (isset($request->new_password)) {
                if (isset($request->current_password)) {
                    if (Hash::check($request->current_password, $request->user->password)) {
                        if ($request->new_password !== $request->current_password) {
                            $request->user->password = Hash::make($request->new_password);
                            unset($errors["message"]);
                        } else {
                            unset($errors["message"]);
                            $errors["new_password"] = "Пароли совпадают!";
                        }
                    } else {
                        $errors["current_password"] = "Неверный текущий пароль!";
                        unset($errors["message"]);
                    }
                } else {
                    unset($errors["message"]);
                    $errors["current_password"] = "Введите текущий пароль!";
                }
            }
            if (count($errors) > 0) {
                return response()->json(["success" => false, "errors" => $errors]);
            } else {
                $request->user->save();
                return response()->json(["success" => true]);
            }
        }
    }

    public function index(Request $request, $id = false){
        if($id !== false){
            return view('tables.users',['rows'=>[User::find($id)]]);
        }
        $data = [];
        if($request->has('sort')){
            $data['rows'] = User::orderBy($request->input('sort'))->paginate(20);
            $data['sort']=$request->input('sort');
        }
        else{
            $data['rows'] = User::paginate(20);
        }

        return view('tables.users',$data);
    }

    public function adminDelete(Request $request)
    {
        $user = User::find($request->route('id'));
        $user->delete();
        return back();
    }

    public function adminEdit(Request $request, $id)
    {
        $data = [];
        $user = User::find($id);
        if($request->input('email')!= $user->email){
            $data['email'] = $request->input('email');
        }
        if($request->input('name')!= $user->name){
            $data['name'] = $request->input('name');
        }
        if($request->input('money')!= $user->money){
            $data['money'] = $request->input('money');
        }
        $validator = Validator::make($data, [
                'email' => 'email|unique:users',
                'name' => 'min:3|max:20',
                'money' => 'min:0|max:7'
            ]
        );
        if (!$validator->fails()) {
            if ($user !== null) {
                foreach ($data as $key=>$val){
                    $user->$key = $val;
                }
                $user->save();
            }
        }
        return back();
    }

}
