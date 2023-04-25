<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Writer extends Model
{
    use HasFactory;
    use HasApiTokens;
    /**
     * Get all of the books for the Writer
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

}
