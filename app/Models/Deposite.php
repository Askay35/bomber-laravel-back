<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposite extends Model
{
    use HasFactory;

    protected $table = 'deposites';

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function status(){
        return $this->hasOne(DepositeStatus::class, 'id','status_id');
    }
    public function system(){
        return $this->hasOne(PaySystem::class, 'id','system_id');
    }
}
