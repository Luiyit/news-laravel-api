<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

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

    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->validateUniquePreference();
        });
    }

    public function validateUniquePreference()
    {
        $existingPreference = Preference::where([
            'user_id' => $this->user_id,
            'preferable_id' => $this->preferable_id,
            'preferable_type' => $this->preferable_type,
        ])->first();

        if ($existingPreference) {
            throw new \Exception('Duplicate record.');
        }
    }

    /**
     * Get all of the models that own preferable.
     */
    public function preferable()
    {
        return $this->morphTo();
    }
}
