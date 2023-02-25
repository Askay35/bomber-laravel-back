<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [\App\Http\Controllers\RegistrationController::class, 'store'])->middleware('throttle:5,1');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login'])->middleware('throttle:10,1');

Route::middleware(['token.exists','user.activity','throttle:30,1'])->group(function(){
    Route::get('/user', [\App\Http\Controllers\UserController::class,'getInfo']);

    Route::post('/user/update/token', function(Request $request){
        return $request->user->updateToken();
    });

    Route::post('/update/online',function (Request $request){
        return response()->json(["success"=>true]);
    });

    Route::post('/user/edit', [\App\Http\Controllers\UserController::class, 'edit']);
});
Route::get('/users/online',function (Request $request){
    return \App\Models\User::where('last_activity','>',\Carbon\Carbon::now()->subMinutes(5)->format('Y-m-d H:i:s'))->count();
})->middleware('throttle:10,1');

Route::get('/bets/top' ,[\App\Http\Controllers\BetController::class, 'getTopBets'])->middleware('throttle:30,1');

