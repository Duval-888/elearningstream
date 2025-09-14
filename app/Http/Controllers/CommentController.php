<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'formation_id' => 'required|exists:formations,id',
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'formation_id' => $request->formation_id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Commentaire ajouté avec succès !');
    }
}
