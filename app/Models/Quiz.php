<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',      // 👈 ajouté
        'title',
        'description',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Ramène automatiquement questions_count (utile pour tes listes)
    protected $withCount = ['questions'];

    /* =======================
       Relations
    ========================*/
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class, 'course_id'); // 👈 ajouté
    }

    public function questions()
    {
        // Tri par ordre (si présent), puis id pour stabilité
        return $this->hasMany(Question::class)
                    ->orderBy('ordre')
                    ->orderBy('id');
    }

    /* =======================
       Scopes pratiques
    ========================*/
    public function scopeMine($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeForCourse($query, $courseId) // 👈 bonus pratique
    {
        return $query->where('course_id', $courseId);
    }

    /* =======================
       Helpers optionnels
    ========================*/
    public function getStatusLabelAttribute(): string
    {
        return $this->is_published ? 'Publié' : 'Brouillon';
    }
}
