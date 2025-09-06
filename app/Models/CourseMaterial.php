<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'type',
        'file_path',
        'external_url',
        'order',
        'is_free',
        'duration'
    ];

    protected $casts = [
        'is_free' => 'boolean',
    ];

    /**
     * Get the course that owns the material
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get file URL
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return $this->external_url;
    }

    /**
     * Check if material is video
     */
    public function isVideo()
    {
        return $this->type === 'video';
    }

    /**
     * Check if material is document
     */
    public function isDocument()
    {
        return $this->type === 'document';
    }

    /**
     * Check if material is quiz
     */
    public function isQuiz()
    {
        return $this->type === 'quiz';
    }

    /**
     * Scope for free materials
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }
}