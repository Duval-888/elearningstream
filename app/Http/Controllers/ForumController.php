<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    /**
     * Display forum dashboard
     */
    public function index()
    {
        try {
            $categories = ForumCategory::active()
                                     ->ordered()
                                     ->with(['discussions' => function($query) {
                                         $query->latest()->take(3);
                                     }])
                                     ->get();

            $recentDiscussions = Discussion::with(['author', 'category', 'latestReply.author'])
                                         ->latest()
                                         ->take(10)
                                         ->get();

            $stats = [
                'total_discussions' => Discussion::count(),
                'total_categories' => ForumCategory::active()->count(),
                'active_users' => Discussion::distinct('author_id')->count('author_id'),
                'today_messages' => Discussion::whereDate('created_at', today())->count() + 
                                  DiscussionReply::whereDate('created_at', today())->count(),
            ];
        } catch (\Exception $e) {
            $categories = collect();
            $recentDiscussions = collect();
            $stats = [
                'total_discussions' => 0,
                'total_categories' => 0,
                'active_users' => 0,
                'today_messages' => 0,
            ];
        }

        return view('dashboard.forums', compact('categories', 'recentDiscussions', 'stats'));
    }

    /**
     * Display discussions in a category
     */
    public function category(ForumCategory $category, Request $request)
    {
        $query = $category->discussions()->with(['author', 'latestReply.author']);

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort
        $sortBy = $request->get('sort', 'last_reply_at');
        $sortOrder = $request->get('order', 'desc');
        
        switch ($sortBy) {
            case 'replies':
                $query->orderBy('reply_count', $sortOrder);
                break;
            case 'views':
                $query->orderBy('view_count', $sortOrder);
                break;
            case 'likes':
                $query->orderBy('like_count', $sortOrder);
                break;
            default:
                $query->orderBy('is_pinned', 'desc')
                      ->orderBy('last_reply_at', $sortOrder);
        }

        $discussions = $query->paginate(20);

        return view('forums.category', compact('category', 'discussions'));
    }

    /**
     * Display a discussion
     */
    public function show(Discussion $discussion)
    {
        $discussion->incrementViews();
        
        $discussion->load([
            'author',
            'category',
            'replies' => function($query) {
                $query->published()
                      ->with(['author', 'children.author'])
                      ->whereNull('parent_id')
                      ->orderBy('created_at');
            }
        ]);

        return view('forums.discussion', compact('discussion'));
    }

    /**
     * Show create discussion form
     */
    public function create(Request $request)
    {
        $categories = ForumCategory::active()->ordered()->get();
        $selectedCategory = $request->get('category');

        return view('forums.create', compact('categories', 'selectedCategory'));
    }

    /**
     * Store a new discussion
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:forum_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $validated['author_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Discussion::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter++;
        }

        $discussion = Discussion::create($validated);

        return redirect()->route('forums.discussion', $discussion)
                        ->with('success', 'Discussion créée avec succès!');
    }

    /**
     * Store a reply to discussion
     */
    public function reply(Request $request, Discussion $discussion)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:discussion_replies,id',
        ]);

        $validated['discussion_id'] = $discussion->id;
        $validated['author_id'] = auth()->id();

        $reply = DiscussionReply::create($validated);

        return back()->with('success', 'Réponse ajoutée avec succès!');
    }

    /**
     * Search discussions
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $categoryId = $request->get('category');

        $discussions = Discussion::with(['author', 'category'])
                                ->when($query, function($q) use ($query) {
                                    $q->search($query);
                                })
                                ->when($categoryId, function($q) use ($categoryId) {
                                    $q->where('category_id', $categoryId);
                                })
                                ->latest()
                                ->paginate(20);

        $categories = ForumCategory::active()->ordered()->get();

        return view('forums.search', compact('discussions', 'categories', 'query', 'categoryId'));
    }
}