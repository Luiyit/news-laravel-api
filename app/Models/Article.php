<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    /**
     * Get the category.
     */
    public function category(): BelongsTo
    {
        return $this->BelongsTo(Category::class);
    }

    /**
     * Get the source.
     */
    public function source(): BelongsTo
    {
        return $this->BelongsTo(Source::class);
    }
}
