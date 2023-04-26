<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Publisher extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'name',
        'slug',
        'image',
    ];

    /**
     * Get all of the book for the Publisher
     */
    public function book(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
