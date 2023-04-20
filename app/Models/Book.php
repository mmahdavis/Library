<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function tags(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function writer(): BelongsTo
    {
        return $this->belongsTo(Writer::class);
    }
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }
    public function translator(): BelongsTo
    {
        return $this->belongsTo(Translator::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
