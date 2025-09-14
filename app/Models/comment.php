<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'formation_id',
        'content',
    ];

    // 🔗 Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Relation avec la formation
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}
