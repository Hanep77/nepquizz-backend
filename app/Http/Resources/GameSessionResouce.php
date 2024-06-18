<?php

namespace App\Http\Resources;

use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameSessionResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "quiz" => new QuizResource($this->whenLoaded('quiz')),
            "score" => $this->score,
            "start_at" => $this->start_at,
            "finished_at" => $this->finished_at,
            "user_answers" => UserAnswerResouce::collection($this->whenLoaded('userAnswers'))
        ];
    }
}
