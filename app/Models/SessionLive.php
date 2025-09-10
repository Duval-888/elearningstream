<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionLive extends Model
{
    protected $fillable = ['title', 'is_active', 'link'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
