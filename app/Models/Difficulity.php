<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Difficulity extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $hidden = ["id"];

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'difficulity_id');
    }
}
