<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Bet extends Model
{

    use HasFactory;

    protected $table = 'bets';

    protected $fillable = [
        'user_id',
        'round_id',
        'bet_size',
        'coef',
        'win',
        'date_time',
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function round(){
        return $this->belongsTo(Round::class);
    }

}
