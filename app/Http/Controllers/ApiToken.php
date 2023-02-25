<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiToken extends Controller
{
    public static function generate()
    {
        $token = hash('sha256', Str::random(60));
        if(User::where('token', $token)->exists()){
            $token = self::generate();
        }
        return $token;
    }
}
