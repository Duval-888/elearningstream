<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'slug',
        'duration',
        'level',
        'category',
        'image',
        'video_url',
        'price',
        'instructor_id',
        'is_published',
        'is_free',
        'max_students',
        'requirements',
        'what_you_learn'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_free' => 'boolean',
        'requirements' => 'array',
        'what_you_learn' => 'array',
    ];

    /**
     * Get the instructor that owns the course
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get course enrollments
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get enrolled students
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')->withPivot('progress', 'completed_at')->withTimestamps();
    }

    /**
     * Get course materials
     */
    public function materials()
    {
        return $this->hasMany(CourseMaterial::class)->orderBy('order');
    }

    /**
     * Get course quizzes
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get live sessions
     */
    public function liveSessions()
    {
        return $this->hasMany(LiveSession::class);
    }

    /**
     * Get certificates issued for this course
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get course statistics
     */
    public function getStatsAttribute()
    {
        return [
            'total_students' => $this->enrollments()->count(),
            'completed_students' => $this->enrollments()->whereNotNull('completed_at')->count(),
            'average_progress' => $this->enrollments()->avg('progress') ?? 0,
            'total_materials' => $this->materials()->count(),
            'total_quizzes' => $this->quizzes()->count(),
        ];
    }

    /**
     * Scope for published courses
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for free courses
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }
}