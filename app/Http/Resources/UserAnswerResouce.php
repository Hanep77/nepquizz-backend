<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAnswerResouce extends JsonResource
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
            "game_session_id" => $this->game_session_id,
            "question_id" => $this->question_id,
            "answer" => new AnswerResource($this->whenLoaded('answer'))
        ];
    }
}
