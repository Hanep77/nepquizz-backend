<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\Uid\UuidV7;

class GameSession extends Model
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

    public function Quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'game_session_id');
    }
}
