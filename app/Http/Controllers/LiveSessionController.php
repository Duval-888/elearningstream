<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\LiveSession;
use App\Models\SessionParticipant;
use Illuminate\Http\Request;

class LiveSessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:formateur,admin')->except(['index', 'show', 'join']);
    }

    /**
     * Display a listing of live sessions
     */
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isInstructor()) {
            $sessions = LiveSession::where('instructor_id', $user->id)
                                  ->with('course')
                                  ->orderBy('scheduled_at', 'desc')
                                  ->paginate(10);
        } else {
            $sessions = LiveSession::with('course', 'instructor')
                                  ->upcoming()
                                  ->orWhere('status', 'live')
                                  ->orderBy('scheduled_at', 'asc')
                                  ->paginate(10);
        }

        return view('live-sessions.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new live session
     */
    public function create()
    {
        $courses = Course::where('instructor_id', auth()->id())->get();
        return view('live-sessions.create', compact('courses'));
    }

    /**
     * Store a newly created live session
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'scheduled_at' => 'required|date|after:now',
            'duration' => 'required|integer|min:15|max:480', // 15 min to 8 hours
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $validated['instructor_id'] = auth()->id();

        // Verify instructor owns the course
        $course = Course::findOrFail($validated['course_id']);
        if ($course->instructor_id !== auth()->id()) {
            return back()->with('error', 'Vous ne pouvez créer une session que pour vos propres cours.');
        }

        $session = LiveSession::create($validated);

        return redirect()->route('live-sessions.show', $session)
                        ->with('success', 'Session live créée avec succès!');
    }

    /**
     * Display the specified live session
     */
    public function show(LiveSession $liveSession)
    {
        $liveSession->load('course', 'instructor', 'participants');
        
        $canJoin = false;
        if (auth()->check()) {
            $user = auth()->user();
            // Check if user is enrolled in the course or is the instructor
            $canJoin = $user->id === $liveSession->instructor_id || 
                      $user->enrolledCourses()->where('course_id', $liveSession->course_id)->exists();
        }

        return view('live-sessions.show', compact('liveSession', 'canJoin'));
    }

    /**
     * Show the form for editing the live session
     */
    public function edit(LiveSession $liveSession)
    {
        if ($liveSession->instructor_id !== auth()->id()) {
            abort(403);
        }

        $courses = Course::where('instructor_id', auth()->id())->get();
        return view('live-sessions.edit', compact('liveSession', 'courses'));
    }

    /**
     * Update the specified live session
     */
    public function update(Request $request, LiveSession $liveSession)
    {
        if ($liveSession->instructor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date',
            'duration' => 'required|integer|min:15|max:480',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $liveSession->update($validated);

        return redirect()->route('live-sessions.show', $liveSession)
                        ->with('success', 'Session mise à jour avec succès!');
    }

    /**
     * Remove the specified live session
     */
    public function destroy(LiveSession $liveSession)
    {
        if ($liveSession->instructor_id !== auth()->id()) {
            abort(403);
        }

        $liveSession->delete();

        return redirect()->route('live-sessions.index')
                        ->with('success', 'Session supprimée avec succès!');
    }

    /**
     * Start a live session
     */
    public function start(LiveSession $liveSession)
    {
        if ($liveSession->instructor_id !== auth()->id()) {
            abort(403);
        }

        $liveSession->start();

        return redirect()->route('live-sessions.room', $liveSession)
                        ->with('success', 'Session démarrée!');
    }

    /**
     * End a live session
     */
    public function end(LiveSession $liveSession)
    {
        if ($liveSession->instructor_id !== auth()->id()) {
            abort(403);
        }

        $liveSession->end();

        return redirect()->route('live-sessions.show', $liveSession)
                        ->with('success', 'Session terminée!');
    }

    /**
     * Join a live session
     */
    public function join(LiveSession $liveSession)
    {
        $user = auth()->user();
        
        // Check if user can join
        if ($user->id !== $liveSession->instructor_id && 
            !$user->enrolledCourses()->where('course_id', $liveSession->course_id)->exists()) {
            return redirect()->route('live-sessions.show', $liveSession)
                           ->with('error', 'Vous devez être inscrit au cours pour rejoindre cette session.');
        }

        // Record participation
        SessionParticipant::updateOrCreate([
            'live_session_id' => $liveSession->id,
            'user_id' => $user->id,
        ], [
            'joined_at' => now(),
        ]);

        return view('live-sessions.room', compact('liveSession'));
    }

    /**
     * Live session room
     */
    public function room(LiveSession $liveSession)
    {
        $user = auth()->user();
        
        // Check permissions
        if ($user->id !== $liveSession->instructor_id && 
            !$user->enrolledCourses()->where('course_id', $liveSession->course_id)->exists()) {
            abort(403);
        }

        return view('live-sessions.room', compact('liveSession'));
    }
}