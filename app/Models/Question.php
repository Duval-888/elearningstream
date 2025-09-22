<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'title',   // le texte de la question
        'ordre',   // position dans le quiz (facultatif)
    ];

    protected $casts = [
        'ordre' => 'integer',
    ];

    /* =======================
       Relations
    ========================*/
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /* =======================
       Scopes pratiques
    ========================*/
    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('id');
    }
}
