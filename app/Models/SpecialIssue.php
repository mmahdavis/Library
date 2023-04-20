<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialIssue extends Model
{
    use HasFactory;

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
