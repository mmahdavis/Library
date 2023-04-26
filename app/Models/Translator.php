<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Translator extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'name',
        'slug',
    ];
    
    /**
     * Get all of the books for the Translator
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
