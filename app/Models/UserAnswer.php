<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswer extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function gameSession(): BelongsTo
    {
        return $this->belongsTo(GameSession::class, 'game_session_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }
}
