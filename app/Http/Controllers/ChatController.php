<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display chat dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        try {
            // Get user's chats
            $chats = Chat::forUser($user)
                        ->with(['latestMessage.author', 'users'])
                        ->orderBy('last_message_at', 'desc')
                        ->get();

            // Get global chat
            $globalChat = Chat::where('type', 'global')->first();
            if (!$globalChat) {
                $globalChat = Chat::create([
                    'name' => 'Chat Global',
                    'type' => 'global',
                    'participants' => [],
                ]);
            }

            // Get recent messages from global chat
            $globalMessages = $globalChat->messages()
                                       ->with('author')
                                       ->latest()
                                       ->take(50)
                                       ->get()
                                       ->reverse()
                                       ->values();

            // Get online users
            $onlineUsers = User::where('is_active', true)
                              ->where('id', '!=', $user->id)
                              ->latest('updated_at')
                              ->take(20)
                              ->get();

            $stats = [
                'total_chats' => $chats->count(),
                'unread_count' => $this->getUnreadCount($user),
                'online_users' => $onlineUsers->count(),
                'total_messages' => ChatMessage::whereHas('chat', function($q) use ($user) {
                    $q->forUser($user);
                })->count(),
            ];
        } catch (\Exception $e) {
            $chats = collect();
            $globalMessages = collect();
            $onlineUsers = collect();
            $stats = [
                'total_chats' => 0,
                'unread_count' => 0,
                'online_users' => 0,
                'total_messages' => 0,
            ];
        }

        return view('dashboard.chat', compact('chats', 'globalMessages', 'onlineUsers', 'stats'));
    }

    /**
     * Display specific chat
     */
    public function show(Chat $chat)
    {
        $user = auth()->user();

        // Check if user has access to this chat
        if (!$chat->hasParticipant($user) && $chat->type !== 'global') {
            abort(403);
        }

        $messages = $chat->messages()
                        ->with(['author', 'replyTo.author'])
                        ->orderBy('created_at')
                        ->paginate(50);

        // Mark messages as read
        if ($chat->hasParticipant($user)) {
            $participant = $chat->chatParticipants()->where('user_id', $user->id)->first();
            $participant?->markAsRead();
        }

        $participants = $chat->users;

        return view('chat.show', compact('chat', 'messages', 'participants'));
    }

    /**
     * Send a message
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'content' => 'required|string|max:2000',
            'reply_to_id' => 'nullable|exists:chat_messages,id',
            'type' => 'in:text,image,file',
        ]);

        $chat = Chat::findOrFail($validated['chat_id']);
        $user = auth()->user();

        // Check access
        if (!$chat->hasParticipant($user) && $chat->type !== 'global') {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }

        // Add user to global chat if not already
        if ($chat->type === 'global' && !$chat->hasParticipant($user)) {
            $chat->addParticipant($user);
        }

        $validated['author_id'] = $user->id;
        $validated['type'] = $validated['type'] ?? 'text';

        $message = ChatMessage::create($validated);
        $message->load('author');

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Get messages for a chat
     */
    public function getMessages(Chat $chat, Request $request)
    {
        $user = auth()->user();

        // Check access
        if (!$chat->hasParticipant($user) && $chat->type !== 'global') {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }

        $page = $request->get('page', 1);
        $perPage = 50;

        $messages = $chat->messages()
                        ->with(['author', 'replyTo.author'])
                        ->orderBy('created_at', 'desc')
                        ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'messages' => $messages->items(),
            'has_more' => $messages->hasMorePages(),
            'current_page' => $messages->currentPage(),
        ]);
    }

    /**
     * Start private chat with user
     */
    public function startPrivateChat(User $user)
    {
        $currentUser = auth()->user();

        if ($user->id === $currentUser->id) {
            return back()->with('error', 'Vous ne pouvez pas démarrer un chat avec vous-même.');
        }

        // Check if private chat already exists
        $existingChat = Chat::where('type', 'private')
                           ->whereJsonContains('participants', $currentUser->id)
                           ->whereJsonContains('participants', $user->id)
                           ->first();

        if ($existingChat) {
            return redirect()->route('chat.show', $existingChat);
        }

        // Create new private chat
        $chat = Chat::create([
            'type' => 'private',
            'participants' => [$currentUser->id, $user->id],
        ]);

        // Add participants
        $chat->addParticipant($currentUser);
        $chat->addParticipant($user);

        return redirect()->route('chat.show', $chat);
    }

    /**
     * Get unread message count for user
     */
    private function getUnreadCount(User $user)
    {
        return $user->chatParticipants()
                   ->with('chat.messages')
                   ->get()
                   ->sum(function ($participant) {
                       return $participant->unread_count;
                   });
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request)
    {
        $validated = $request->validate([
            'chat_id' => 'required|exists:chats,id',
        ]);

        $user = auth()->user();
        $chat = Chat::findOrFail($validated['chat_id']);

        $participant = $chat->chatParticipants()->where('user_id', $user->id)->first();
        $participant?->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Get online users
     */
    public function getOnlineUsers()
    {
        $users = User::where('is_active', true)
                    ->where('id', '!=', auth()->id())
                    ->select('id', 'name', 'avatar', 'role', 'updated_at')
                    ->latest('updated_at')
                    ->take(50)
                    ->get();

        return response()->json($users);
    }
}