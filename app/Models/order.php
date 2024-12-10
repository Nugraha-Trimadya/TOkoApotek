<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\models\User;

class order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medicines',
        'name_costumer',
        'total_price',
    ];

    protected $casts = [
        'medicines' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
