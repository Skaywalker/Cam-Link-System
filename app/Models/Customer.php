<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'email',
        'tel',
        'user_id'
    ];
    protected $hidden=[
        'created_at',
        'updated_at',
        ];
    public function customerToRecorders(){
        return $this->hasMany(Recorder::class);
    }
    public function costumerToUser(){
        return $this->hasOne(User::class,'id','user_id');
    }

}
