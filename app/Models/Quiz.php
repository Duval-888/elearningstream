<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',     // ✅ pour lier à un cours
        'video_id',      // ✅ pour lier à une vidéo
        'title',
        'description',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Ramène automatiquement le nombre de questions
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
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    public function questions()
    {
        // Tri par 'ordre' si présent, puis par id
        return $this->hasMany(Question::class)
                    ->orderBy('ordre')
                    ->orderBy('id');
    }

    /* =======================
       Scopes
    ========================*/
    public function scopeMine($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /* =======================
       Accessors / Helpers
    ========================*/
    public function getStatusLabelAttribute(): string
    {
        return $this->is_published ? 'Publié' : 'Brouillon';
    }
}
