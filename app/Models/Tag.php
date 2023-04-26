<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Laravel\Sanctum\HasApiTokens;

class Tag extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'name',
        'slug',
    ];
    
    /**
     * Get all of the books for the Tag
     */
    public function books(): BelongsToMany
    {
        return $this->BelongsToMany(Book::class);
    }
    /**
     * Get all of the specialIssue for the Tag
     */
    public function specialIssue(): HasMany
    {
        return $this->hasMany(SpecialIssue::class);
    }

}
