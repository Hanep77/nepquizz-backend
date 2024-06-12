<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\Uid\UuidV7;

class Quiz extends Model
{
    use HasFactory;

    protected $keyType = "string";
    public $incrementing = false;

    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = UuidV7::generate();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function difficulity(): BelongsTo
    {
        return $this->belongsTo(Difficulity::class, 'difficulity_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }

    public function gameSession(): HasMany
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }
}
