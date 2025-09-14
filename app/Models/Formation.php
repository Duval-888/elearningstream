<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    'video_url', // ✅ Ajouté ici
];


    public function apprenants()
    {
        return $this->belongsToMany(User::class)->withPivot('progression')->withTimestamps();
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


}
