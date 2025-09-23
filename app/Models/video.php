<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Video extends Model
{
   // app/Models/Video.php
protected $fillable = [
    'formation_id', 'title', 'ordre', 'video_url', 'mime_type', 
];

    // Relation avec les utilisateurs qui ont vu la vidéo
    public function vusPar()
    {
        return $this->belongsToMany(User::class)->withPivot('viewed_at')->withTimestamps();
    }

    // Marquer la vidéo comme vue par l'utilisateur connecté
    public function marquerVue()
    {
        Auth::user()->videosVues()->syncWithoutDetaching([
            $this->id => ['viewed_at' => now()]
        ]);
    }

    public function quizzes()
{
    return $this->hasMany(\App\Models\Quiz::class);
}

public function formation()
{
    return $this->belongsTo(\App\Models\Formation::class);
}


}
