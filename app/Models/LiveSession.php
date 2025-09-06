<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LiveSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'instructor_id',
        'scheduled_at',
        'duration',
        'meeting_url',
        'meeting_id',
        'meeting_password',
        'status',
        'max_participants',
        'is_recorded',
        'recording_url'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_recorded' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($session) {
            if (empty($session->meeting_id)) {
                $session->meeting_id = Str::random(10);
            }
            if (empty($session->meeting_password)) {
                $session->meeting_password = Str::random(6);
            }
        });
    }

    /**
     * Get the course that owns the session
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the instructor that owns the session
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get session participants
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'session_participants')
                    ->withPivot('joined_at', 'left_at', 'duration_minutes')
                    ->withTimestamps();
    }

    /**
     * Check if session is live
     */
    public function isLive()
    {
        return $this->status === 'live';
    }

    /**
     * Check if session is scheduled
     */
    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }

    /**
     * Start the session
     */
    public function start()
    {
        $this->update(['status' => 'live']);
    }

    /**
     * End the session
     */
    public function end()
    {
        $this->update(['status' => 'completed']);
    }

    /**
     * Get session join URL
     */
    public function getJoinUrlAttribute()
    {
        return route('live-session.join', $this->id);
    }

    /**
     * Scope for upcoming sessions
     */
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>', now())
                    ->where('status', 'scheduled');
    }

    /**
     * Scope for live sessions
     */
    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }
}