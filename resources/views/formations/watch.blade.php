{{-- resources/views/formations/watch.blade.php --}}
<x-layouts.dashboard>
    @php
        use Illuminate\Support\Str;

        $posterUrl = isset($formation->cover_image) && $formation->cover_image
            ? (Str::startsWith($formation->cover_image, ['http://','https://'])
                ? $formation->cover_image
                : asset('storage/'.$formation->cover_image))
            : '';

        // Petite aide pour deviner un mime si non stocké
        $guessMime = function (string $src) {
            $lower = Str::lower($src);
            return match (true) {
                Str::endsWith($lower, '.mp4')  => 'video/mp4',
                Str::endsWith($lower, '.webm') => 'video/webm',
                Str::endsWith($lower, ['.ogg','.ogv']) => 'video/ogg',
                Str::endsWith($lower, '.mkv')  => 'video/x-matroska',
                Str::endsWith($lower, '.avi')  => 'video/x-msvideo',
                Str::endsWith($lower, '.mov')  => 'video/quicktime',
                Str::endsWith($lower, '.m4v')  => 'video/x-m4v',
                default => 'video/mp4',
            };
        };

        // On prépare une liste « playlist » avec les champs déjà compatibles player
        $prepared = $videos->map(function ($v) use ($guessMime) {
            $url = $v->video_url ?? '';
            $isYouTube = (bool) preg_match('/(youtube\.com|youtu\.be)/i', $url);

            // Embed YT si besoin
            $embed = null;
            if ($isYouTube) {
                if (Str::contains($url, 'watch?v=')) {
                    $embed = Str::replace('watch?v=', 'embed/', $url);
                } elseif (Str::contains($url, 'youtu.be/')) {
                    $id = Str::after($url, 'youtu.be/');
                    $id = Str::before($id, '?');
                    $embed = 'https://www.youtube.com/embed/' . trim($id, '/');
                } elseif (Str::contains($url, '/shorts/')) {
                    $id = Str::after($url, '/shorts/');
                    $id = Str::before($id, '?');
                    $embed = 'https://www.youtube.com/embed/' . trim($id, '/');
                }
            }

            // Chemin fichier local => asset()
            $src = $url;
            if (!$isYouTube && $src && !Str::startsWith($src, ['http://','https://','//'])) {
                $src = asset($src);
            }

            // MIME
            $mime = $v->mime_type ?? $guessMime($src);

            return [
                'id'     => $v->id,
                'title'  => $v->title,
                'ordre'  => $v->ordre,
                'type'   => $isYouTube ? 'youtube' : 'file',
                'src'    => $isYouTube ? ($embed ?: $url) : $src, // pour YT on stocke l’embed
                'mime'   => $mime,
                'raw'    => $url, // pour info/debug
            ];
        })->values();
    @endphp

    <div class="max-w-7xl mx-auto px-4 py-6">
        {{-- En-tête --}}
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $formation->title }}</h1>
                <p class="text-sm text-gray-600">
                    Niveau : {{ ucfirst($formation->level) }} • {{ $videos->count() }} vidéos
                </p>
            </div>

            <a href="{{ url('/mes-formations') }}"
               class="text-indigo-600 hover:text-indigo-800 text-sm">← Retour</a>
        </div>

        @if($videos->isEmpty())
            <div class="p-6 bg-yellow-50 border border-yellow-200 rounded-xl text-yellow-800">
                Aucune vidéo n’a encore été ajoutée à cette formation.
            </div>
        @else
            {{-- Player principal (un seul bloc, on bascule en JS) --}}
            <div class="bg-black rounded-2xl overflow-hidden shadow-xl relative mb-6">
                {{-- HTML5 video --}}
                <video id="player-file"
                       class="w-full aspect-video hidden"
                       poster="{{ $posterUrl }}"
                       preload="metadata"
                       controls></video>

                {{-- YouTube --}}
                <iframe id="player-yt"
                        class="w-full aspect-video hidden"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>

                {{-- Barre d’actions overlay --}}
                <div class="absolute inset-x-0 bottom-0 flex items-center justify-between px-4 py-3 bg-gradient-to-t from-black/70 to-transparent text-white">
                    <div class="flex items-center gap-3">
                        <button id="btn-prev" class="px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/20">Précédent</button>
                        <button id="btn-next" class="px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/20">Suivant</button>
                    </div>
                    <div id="now-title" class="text-sm opacity-90 truncate max-w-[70%]"></div>
                </div>
            </div>

            {{-- Playlist --}}
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Contenu du cours</h2>
            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="playlist">
                @foreach($prepared as $item)
                    <li>
                        <button
                            class="w-full text-left group bg-white rounded-xl border hover:border-indigo-300 hover:shadow-md overflow-hidden transition relative item"
                            data-id="{{ $item['id'] }}"
                            data-title="{{ $item['title'] }}"
                            data-ordre="{{ $item['ordre'] ?? '' }}"
                            data-type="{{ $item['type'] }}"
                            data-src="{{ $item['src'] }}"
                            data-mime="{{ $item['mime'] }}"
                        >
                            <div class="relative">
                                <img src="{{ $posterUrl ?: 'https://via.placeholder.com/640x360' }}"
                                     alt="miniature" class="w-full h-36 object-cover">
                                <span class="absolute bottom-2 right-2 text-[10px] px-2 py-1 rounded bg-white/80 text-gray-900">
                                    Chapitre {{ $item['ordre'] ?? '-' }}
                                </span>
                                <span class="absolute top-2 left-2 text-[10px] px-2 py-1 rounded bg-black/70 text-white">
                                    {{ $item['type']==='youtube' ? 'YouTube' : Str::upper(Str::after($item['mime'],'/')) }}
                                </span>
                            </div>
                            <div class="p-3">
                                <p class="font-medium text-gray-900 line-clamp-2">{{ $item['title'] }}</p>
                            </div>
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        (function () {
            const items = Array.from(document.querySelectorAll('#playlist .item'));
            if (!items.length) return;

            const playerFile = document.getElementById('player-file');
            const playerYt   = document.getElementById('player-yt');
            const nowTitle   = document.getElementById('now-title');
            const btnPrev    = document.getElementById('btn-prev');
            const btnNext    = document.getElementById('btn-next');

            // On construit la playlist à partir des data-*
            const videos = items.map(el => ({
                el,
                id:    +el.dataset.id,
                title: el.dataset.title,
                ordre: el.dataset.ordre ? parseInt(el.dataset.ordre,10) : null,
                type:  el.dataset.type,
                src:   el.dataset.src,
                mime:  el.dataset.mime || 'video/mp4',
            }));

            // Tri par ordre si renseigné, sinon ordre d’affichage
            videos.sort((a,b) => {
                if (a.ordre === null && b.ordre === null) return 0;
                if (a.ordre === null) return 1;
                if (b.ordre === null) return -1;
                return a.ordre - b.ordre;
            });

            let index = 0;

            function markViewed(videoId) {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch(`/videos/${videoId}/vue`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
                }).catch(()=>{});
            }

            function stopAll() {
                try { playerFile.pause(); } catch(_) {}
                playerFile.classList.add('hidden');
                playerFile.removeAttribute('src');
                while (playerFile.firstChild) playerFile.removeChild(playerFile.firstChild);

                playerYt.classList.add('hidden');
                playerYt.removeAttribute('src');
            }

            function playAt(i) {
                if (i < 0 || i >= videos.length) return;
                index = i;
                const v = videos[index];

                stopAll();

                // Titre en overlay
                nowTitle.textContent = (v.ordre ? (v.ordre + '. ') : '') + v.title;

                // Sélection visuelle
                videos.forEach((x,k) => {
                    x.el.classList.toggle('ring-2', k === index);
                    x.el.classList.toggle('ring-indigo-500', k === index);
                    x.el.classList.toggle('border-indigo-500', k === index);
                });

                // Play
                if (v.type === 'youtube') {
                    // Ajoute autoplay=1 si absent
                    const url = v.src.includes('?') ? (v.src + '&autoplay=1&rel=0') : (v.src + '?autoplay=1&rel=0');
                    playerYt.src = url;
                    playerYt.classList.remove('hidden');
                } else {
                    const source = document.createElement('source');
                    source.src = v.src;
                    source.type = v.mime || 'video/mp4';
                    playerFile.appendChild(source);
                    playerFile.classList.remove('hidden');
                    // autoplay
                    try { playerFile.play(); } catch (_) {}
                }
            }

            // Marquer vu en fin de lecture locale
            playerFile.addEventListener('ended', () => {
                const v = videos[index];
                markViewed(v.id);
                if (index < videos.length - 1) playAt(index + 1);
            });

            btnPrev.addEventListener('click', () => { if (index > 0) playAt(index - 1); });
            btnNext.addEventListener('click', () => { if (index < videos.length - 1) playAt(index + 1); });

            // Click playlist
            document.getElementById('playlist').addEventListener('click', (e) => {
                const btn = e.target.closest('.item'); if (!btn) return;
                const id = +btn.dataset.id;
                const i = videos.findIndex(x => x.id === id);
                if (i !== -1) playAt(i);
            });

            // Raccourcis clavier
            window.addEventListener('keydown', (e) => {
                if (['INPUT','TEXTAREA'].includes(document.activeElement.tagName)) return;
                if (e.key === 'ArrowRight') { e.preventDefault(); btnNext.click(); }
                if (e.key === 'ArrowLeft')  { e.preventDefault(); btnPrev.click(); }
                if (e.code === 'Space')     {
                    e.preventDefault();
                    if (!playerFile.classList.contains('hidden')) {
                        if (playerFile.paused) playerFile.play(); else playerFile.pause();
                    }
                }
            });

            // Démarre sur la 1ère vidéo
            playAt(0);
        })();
    </script>
</x-layouts.dashboard>
