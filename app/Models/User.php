<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
        'avatar',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get the courses that belong to the user (for instructors)
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    /**
     * Get the courses the user is enrolled in (for students)
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get enrolled courses
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')->withPivot('progress', 'completed_at')->withTimestamps();
    }

    /**
     * Get user's certificates
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get live sessions as instructor
     */
    public function instructorSessions()
    {
        return $this->hasMany(LiveSession::class, 'instructor_id');
    }

    /**
     * Get live sessions as participant
     */
    public function participantSessions()
    {
        return $this->belongsToMany(LiveSession::class, 'session_participants')->withPivot('joined_at', 'left_at', 'duration_minutes')->withTimestamps();
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is instructor
     */
    public function isInstructor()
    {
        return $this->role === 'formateur';
    }

    /**
     * Check if user is student
     */
    public function isStudent()
    {
        return $this->role === 'apprenant';
    }
     

    public function formations()
{
    return $this->belongsToMany(Formation::class)->withPivot('progression')->withTimestamps();
}

public function certificats()
{
    return $this->hasMany(Certificat::class);
}

public function videosVues()
{
    return $this->belongsToMany(Video::class)->withPivot('viewed_at')->withTimestamps();
}


}