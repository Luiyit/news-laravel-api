<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'preferable_type',
        'preferable_id',
    ];

    /**
     * Get all of the models that own preferable.
     */
    public function preferable()
    {
        return $this->morphTo();
    }
}
