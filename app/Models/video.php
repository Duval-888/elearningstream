<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class video extends Model
{
    public function formation()
{
    return $this->belongsTo(Formation::class);
}

public function vusPar()
{
    return $this->belongsToMany(User::class)->withPivot('viewed_at')->withTimestamps();
}

public function marquerVue(Video $video)
{
    auth()->user()->videosVues()->syncWithoutDetaching([
        $video->id => ['viewed_at' => now()]
    ]);

    return back()->with('success', 'Vidéo marquée comme vue.');
}


}
