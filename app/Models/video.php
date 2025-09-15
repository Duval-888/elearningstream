<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Video extends Model
{
    protected $fillable = [
        'title',
        'video_url',
        'ordre',
        'formation_id',
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
}
