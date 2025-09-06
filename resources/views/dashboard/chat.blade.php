@extends('layouts.app')

@section('title', 'Dashboard Chat')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Chat</h1>
        <p class="text-gray-600">Communiquez en temps réel avec la communauté</p>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-comments text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Mes Chats</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['total_chats'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-bell text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Messages Non Lus</h3>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['unread_count'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">En Ligne</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['online_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-message text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Total Messages</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['total_messages'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Chat Global -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Chat Global</h2>
                    <div class="flex items-center text-sm text-gray-600">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                        <span>{{ $stats['online_users'] }} en ligne</span>
                    </div>
                </div>
            </div>
            
            <div class="h-96 overflow-y-auto p-6 space-y-4" id="chat-messages">
                @if($globalMessages->count() > 0)
                    @foreach($globalMessages as $message)
                        <div class="flex items-start space-x-3 {{ $message->author_id === auth()->id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                            <img src="{{ $message->author->avatar ?? 'https://i.pravatar.cc/150?img=' . $message->author->id }}" 
                                 alt="{{ $message->author->name }}" 
                                 class="w-8 h-8 rounded-full">
                            <div class="flex-1 max-w-xs lg:max-w-md">
                                <div class="bg-gray-100 rounded-lg p-3 {{ $message->author_id === auth()->id() ? 'bg-blue-500 text-white' : '' }}">
                                    <p class="text-sm font-medium {{ $message->author_id === auth()->id() ? 'text-blue-100' : 'text-gray-600' }}">
                                        {{ $message->author->name }}
                                    </p>
                                    <p class="text-sm">{{ $message->content }}</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $message->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">Aucun message</h3>
                        <p class="text-gray-500">Soyez le premier à envoyer un message</p>
                    </div>
                @endif
            </div>

            <!-- Zone de saisie -->
            <div class="p-6 border-t border-gray-200">
                <form id="chat-form" class="flex space-x-4">
                    @csrf
                    <input type="hidden" name="chat_id" value="1">
                    <div class="flex-1">
                        <input type="text" 
                               name="content" 
                               id="message-input"
                               placeholder="Tapez votre message..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               maxlength="2000">
                    </div>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Utilisateurs en ligne -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Utilisateurs en ligne</h3>
                
                @if($onlineUsers->count() > 0)
                    <div class="space-y-3">
                        @foreach($onlineUsers->take(10) as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <img src="{{ $user->avatar ?? 'https://i.pravatar.cc/150?img=' . $user->id }}" 
                                             alt="{{ $user->name }}" 
                                             class="w-8 h-8 rounded-full">
                                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ ucfirst($user->role) }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('chat.private', $user) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-comment"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-user-slash text-2xl text-gray-300 mb-2"></i>
                        <p class="text-sm text-gray-500">Aucun utilisateur en ligne</p>
                    </div>
                @endif
            </div>

            <!-- Mes conversations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Mes Conversations</h3>
                    <a href="{{ route('chat.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        Voir toutes
                    </a>
                </div>
                
                @if($chats->count() > 0)
                    <div class="space-y-3">
                        @foreach($chats->take(5) as $chat)
                            <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition duration-300">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        <i class="fas fa-{{ $chat->type === 'private' ? 'user' : 'users' }} text-gray-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $chat->name ?: 'Chat ' . ucfirst($chat->type) }}
                                        </p>
                                        @if($chat->latestMessage)
                                            <p class="text-xs text-gray-500">
                                                {{ Str::limit($chat->latestMessage->content, 30) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($chat->latestMessage)
                                        <p class="text-xs text-gray-500">
                                            {{ $chat->latestMessage->created_at->diffForHumans() }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-comment-slash text-2xl text-gray-300 mb-2"></i>
                        <p class="text-sm text-gray-500">Aucune conversation</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const chatMessages = document.getElementById('chat-messages');

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(chatForm);
        const content = messageInput.value.trim();
        
        if (!content) return;

        // Disable form
        messageInput.disabled = true;
        
        fetch('{{ route("chat.send") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear input
                messageInput.value = '';
                
                // Add message to chat (simplified)
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            messageInput.disabled = false;
            messageInput.focus();
        });
    });

    // Auto-scroll to bottom
    chatMessages.scrollTop = chatMessages.scrollHeight;
});
</script>
@endpush
@endsection