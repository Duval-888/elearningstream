<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\LiveSession;
use App\Models\Certificate;
use App\Models\User;

class SearchController extends Controller
{
public function global(Request $request)
{
$query = $request->input('query');
$type = $request->input('type');

$results = [];

// Recherche dans les cours
if ($type === 'cours' || !$type) {
$results['cours'] = Course::where('title', 'like', "%$query%")
                            ->orWhere('description', 'like', "%$query%")
                            ->get();
}

// Recherche dans les sessions live
if ($type === 'session' || !$type) {
$results['sessions'] = LiveSession::where('title', 'like', "%$query%")
                                    ->orWhere('description', 'like', "%$query%")
                                    ->get();
}

// Recherche dans les certificats
if ($type === 'certificat' || !$type) {
$results['certificats'] = Certificate::whereHas('course', function ($q) use ($query) {
    $q->where('title', 'like', "%$query%");
})->get();
}

// Recherche dans les utilisateurs ou apprenants
if ($type === 'utilisateur' || $type === 'apprenant' || !$type) {
$results['utilisateurs'] = User::where('name', 'like', "%$query%")
                                ->orWhere('email', 'like', "%$query%")
                                ->get();
}

return view('search.results', compact('results', 'query', 'type'));
}
}
