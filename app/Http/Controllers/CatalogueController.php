<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $formations = Formation::where('is_active', true)
            ->when($request->level, fn($q) => $q->where('level', $request->level))
            ->when($request->price_max, fn($q) => $q->where('price', '<=', $request->price_max))
            ->paginate(12);

        return view('formations.catalogue', compact('formations'));
    }
}
