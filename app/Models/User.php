<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;


class User extends Authenticatable
{

    use HasFactory, Notifiable;

    //menentukan kolom yang boleh diisi 
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    //menentukan kolom yang tidak boleh diisi /tersembunyi
    protected $hidden = [
        'password',
        'remember_token',
    ];

    //mengkonversi tipe data ke  datetime 
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function order(){
        return $this->hasMany(Order::class);
    }
}
