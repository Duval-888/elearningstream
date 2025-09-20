<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Formation extends Model
{
    protected $fillable = [
        'title',
        'description',
        'slug',
        'level',
        'price',
        'is_active',
        'creator_id',
        'video_url',
    ];

    public function apprenants()
    {
        return $this->belongsToMany(User::class)->withPivot('progression')->withTimestamps();
    }

    public function creator()
{
    return $this->belongsTo(User::class, 'creator_id');
}

    public function sessionsLive()
    {
        return $this->hasMany(SessionLive::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(\App\Models\Inscription::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function videos()
{
    return $this->hasMany(Video::class);
}

protected static function boot()
{
    parent::boot();

    static::creating(function ($formation) {
        if (empty($formation->slug)) {
            $baseSlug = Str::slug($formation->title);
            $formation->slug = $baseSlug;

            // Évite les doublons
            if (Formation::where('slug', $baseSlug)->exists()) {
                $formation->slug = $baseSlug . '-' . uniqid();
            }
        }
    });
}



}

