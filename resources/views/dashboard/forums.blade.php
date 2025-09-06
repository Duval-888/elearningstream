@extends('layouts.app')

@section('title', 'Dashboard Forums')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Forums</h1>
        <p class="text-gray-600">Participez aux discussions et échangez avec la communauté</p>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-comments text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Discussions</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['total_discussions'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-folder text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Catégories</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['total_categories'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Utilisateurs Actifs</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['active_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-message text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Messages Aujourd'hui</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['today_messages'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
            <div class="text-center">
                <div class="p-4 rounded-full bg-blue-100 text-blue-600 inline-block mb-4">
                    <i class="fas fa-plus text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Nouvelle Discussion</h3>
                <p class="text-gray-600 mb-4">Créez une nouvelle discussion dans le forum</p>
                <a href="{{ route('forums.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300">
                    Créer Discussion
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
            <div class="text-center">
                <div class="p-4 rounded-full bg-green-100 text-green-600 inline-block mb-4">
                    <i class="fas fa-search text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Rechercher</h3>
                <p class="text-gray-600 mb-4">Trouvez des discussions par mots-clés</p>
                <a href="{{ route('forums.search') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300">
                    Rechercher
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
            <div class="text-center">
                <div class="p-4 rounded-full bg-purple-100 text-purple-600 inline-block mb-4">
                    <i class="fas fa-chart-bar text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Mes Contributions</h3>
                <p class="text-gray-600 mb-4">Voir mes discussions et réponses</p>
                <a href="{{ route('forums.my-contributions') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300">
                    Voir Mes Posts
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Catégories de forums -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Catégories de Forums</h2>
            
            @if($categories->count() > 0)
                <div class="space-y-4">
                    @foreach($categories as $category)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">
                                            <a href="{{ route('forums.category', $category) }}" class="hover:text-blue-600">
                                                {{ $category->name }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-600">{{ $category->description }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-800">{{ $category->discussion_count }} discussions</p>
                                    <p class="text-xs text-gray-500">{{ $category->message_count }} messages</p>
                                </div>
                            </div>
                            
                            @if($category->last_message)
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <img src="{{ $category->last_message->author->avatar ?? 'https://i.pravatar.cc/150?img=1' }}" 
                                             alt="{{ $category->last_message->author->name }}" 
                                             class="w-6 h-6 rounded-full mr-2">
                                        <span>Dernier message par {{ $category->last_message->author->name }}</span>
                                        <span class="ml-auto">{{ $category->last_message->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-folder-open text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Aucune catégorie</h3>
                    <p class="text-gray-500">Les catégories de forum seront bientôt disponibles</p>
                </div>
            @endif
        </div>

        <!-- Discussions récentes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Discussions Récentes</h2>
                <a href="{{ route('forums.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Voir toutes <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($recentDiscussions->count() > 0)
                <div class="space-y-4">
                    @foreach($recentDiscussions->take(8) as $discussion)
                        <div class="border-b border-gray-100 pb-4 last:border-b-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-800 hover:text-blue-600">
                                        <a href="{{ route('forums.discussion', $discussion) }}">
                                            {{ Str::limit($discussion->title, 60) }}
                                        </a>
                                    </h3>
                                    <div class="flex items-center mt-1 text-sm text-gray-600">
                                        <img src="{{ $discussion->author->avatar ?? 'https://i.pravatar.cc/150?img=' . $discussion->author->id }}" 
                                             alt="{{ $discussion->author->name }}" 
                                             class="w-5 h-5 rounded-full mr-2">
                                        <span>{{ $discussion->author->name }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $discussion->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="ml-4 text-right">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-reply mr-1"></i>
                                        <span>{{ $discussion->reply_count }}</span>
                                        <i class="fas fa-eye ml-3 mr-1"></i>
                                        <span>{{ $discussion->view_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Aucune discussion</h3>
                    <p class="text-gray-500 mb-4">Soyez le premier à créer une discussion</p>
                    <a href="{{ route('forums.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition duration-300">
                        <i class="fas fa-plus mr-2"></i>Créer une discussion
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection