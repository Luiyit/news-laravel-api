<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
    use HasFactory;

    /**
     * Get the articles for the source.
     */
    public function article(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get all of the users that prefer it.
     */
    public function preferences()
    {
        return $this->morphMany(Preference::class, 'preferable');
    }
}
