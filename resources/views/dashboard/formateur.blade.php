<x-layout title="Dashboard Formateur">
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Formateur</h1>
        <p class="text-gray-600">Gérez vos cours et suivez vos apprenants</p>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-book text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Mes Cours</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $courses->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-eye text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Cours Publiés</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $courses->where('is_published', true)->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Brouillons</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $courses->where('is_published', false)->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Apprenants</h3>
                    <p class="text-2xl font-bold text-purple-600">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
            <div class="text-center">
                <div class="p-4 rounded-full bg-blue-100 text-blue-600 inline-block mb-4">
                    <i class="fas fa-plus text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Créer un Cours</h3>
                <p class="text-gray-600 mb-4">Créez un nouveau cours pour vos apprenants</p>
                <a href="{{ route('courses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300">
                    Nouveau Cours
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
            <div class="text-center">
                <div class="p-4 rounded-full bg-green-100 text-green-600 inline-block mb-4">
                    <i class="fas fa-list text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Gérer mes Cours</h3>
                <p class="text-gray-600 mb-4">Consultez et modifiez vos cours existants</p>
                <a href="{{ route('courses.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300">
                    Mes Cours
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
            <div class="text-center">
                <div class="p-4 rounded-full bg-purple-100 text-purple-600 inline-block mb-4">
                    <i class="fas fa-chart-bar text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Statistiques</h3>
                <p class="text-gray-600 mb-4">Suivez les performances de vos cours</p>
                <button class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300" disabled>
                    Bientôt disponible
                </button>
            </div>
        </div>
    </div>

    <!-- Cours récents -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Mes Cours Récents</h2>
            <a href="{{ route('courses.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                Voir tous <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        @if(Auth::check() && Auth::user()->courses()->exists())
            <div class="space-y-4">
                @foreach(Auth::user()->courses()->latest()->take(5)->get() as $course)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-300">
                        <div class="flex items-center">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-12 h-12 object-cover rounded-lg mr-4">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-book text-gray-400"></i>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $course->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $course->category }} • {{ $course->level }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs rounded-full {{ $course->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $course->is_published ? 'Publié' : 'Brouillon' }}
                            </span>
                            <a href="{{ route('courses.show', $course) }}" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('courses.edit', $course) }}" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-book text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Aucun cours créé</h3>
                <p class="text-gray-500 mb-4">Commencez par créer votre premier cours</p>
                <a href="{{ route('courses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300">
                    <i class="fas fa-plus mr-2"></i>Créer mon premier cours
                </a>
            </div>
        @endif
    </div>
</div>
</x-layout>