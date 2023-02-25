<?php

namespace App\Models;

use App\Http\Controllers\ApiToken;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        "token",
        "money",
        "last_activity"
    ];
    protected $hidden = [
      "password"
    ];

    public function bets(){
        return $this->hasMany(Bet::class);
    }

    public function deposites(){
        return $this->hasMany(Deposite::class);
    }

    public function withdraws(){
        return $this->hasMany(Withdraw::class);
    }

    public function updateToken()
    {
        $this->last_activity = new \DateTime;
        $this->token = ApiToken::generate().str_pad($this->id, 3, STR_PAD_LEFT);
        $this->save();
        return response()->json(["success" => true, "data" => ["token" => $this->token]]);
    }
}
