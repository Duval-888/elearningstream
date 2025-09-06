<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'questions',
        'time_limit',
        'max_attempts',
        'passing_score',
        'is_active'
    ];

    protected $casts = [
        'questions' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the course that owns the quiz
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get quiz attempts
     */
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Get total questions count
     */
    public function getTotalQuestionsAttribute()
    {
        return count($this->questions ?? []);
    }

    /**
     * Check if user can take quiz
     */
    public function canUserTake(User $user)
    {
        if (!$this->is_active) {
            return false;
        }

        $attempts = $this->attempts()->where('user_id', $user->id)->count();
        return $attempts < $this->max_attempts;
    }

    /**
     * Get user's best score
     */
    public function getUserBestScore(User $user)
    {
        return $this->attempts()
                   ->where('user_id', $user->id)
                   ->max('score') ?? 0;
    }
}