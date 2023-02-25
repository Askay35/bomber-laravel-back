<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class TokenExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(isset($request->token)){
            $user = User::where('token', $request->token)->first();
            if ($user !== null) {
                $request->user = $user;
            }
            else{
                return response(["success" => false, "data" => ["token" => "Неверный токен!"]]);
            }
        }
        else{
            return response(["success" => false, "data" => ["token" => "Токен не указан!"]]);
        }
        return $next($request);
    }
}
