<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class SpecialIssue extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get the category that owns the SpecialIssue
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * Get the tag that owns the SpecialIssue
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
