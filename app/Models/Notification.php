<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Notification extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'checked',
    ];
}
