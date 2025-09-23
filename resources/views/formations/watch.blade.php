{{-- resources/views/formations/watch.blade.php --}}
<x-layouts.dashboard>
    @php
        // Couverture (FQCN pour Str)
        $cover = $formation->cover_image ?? null;
        $posterUrl = $cover
            ? (\Illuminate\Support\Str::startsWith($cover, ['http://','https://'])
                ? $cover
                : asset('storage/'.$cover))
            : 'https://via.placeholder.com/1280x720?text=Formation';

        // Devine le type MIME si manquant (toujours FQCN)
        $guessMime = function (string $src) {
            $lower = \Illuminate\Support\Str::lower($src);
            return match (true) {
                \Illuminate\Support\Str::endsWith($lower, '.mp4')  => 'video/mp4',
                \Illuminate\Support\Str::endsWith($lower, '.webm') => 'video/webm',
                \Illuminate\Support\Str::endsWith($lower, ['.ogg','.ogv']) => 'video/ogg',
                \Illuminate\Support\Str::endsWith($lower, '.mkv')  => 'video/x-matroska',
                \Illuminate\Support\Str::endsWith($lower, '.avi')  => 'video/x-msvideo',
                \Illuminate\Support\Str::endsWith($lower, '.mov')  => 'video/quicktime',
                \Illuminate\Support\Str::endsWith($lower, '.m4v')  => 'video/x-m4v',
                default => 'video/mp4',
            };
        };

        // Prépare la playlist (sans changer la logique)
        $prepared = $videos->map(function ($v) use ($guessMime) {
            $url = $v->video_url ?? '';
            $isYouTube = (bool) preg_match('/(youtube\.com|youtu\.be)/i', $url);

            // Génère l'embed YouTube si besoin
            $embed = null;
            if ($isYouTube) {
                if (\Illuminate\Support\Str::contains($url, 'watch?v=')) {
                    $embed = \Illuminate\Support\Str::replace('watch?v=', 'embed/', $url);
                } elseif (\Illuminate\Support\Str::contains($url, 'youtu.be/')) {
                    $id = \Illuminate\Support\Str::after($url, 'youtu.be/');
                    $id = \Illuminate\Support\Str::before($id, '?');
                    $embed = 'https://www.youtube.com/embed/' . trim($id, '/');
                } elseif (\Illuminate\Support\Str::contains($url, '/shorts/')) {
                    $id = \Illuminate\Support\Str::after($url, '/shorts/');
                    $id = \Illuminate\Support\Str::before($id, '?');
                    $embed = 'https://www.youtube.com/embed/' . trim($id, '/');
                }
            }

            // Chemin local => asset()
            $src = $url;
            if (!$isYouTube && $src && !\Illuminate\Support\Str::startsWith($src, ['http://','https://','//'])) {
                $src = asset($src);
            }

            $mime = $v->mime_type ?? $guessMime($src);

            return [
                'id'     => $v->id,
                'title'  => $v->title,
                'ordre'  => $v->ordre,
                'type'   => $isYouTube ? 'youtube' : 'file',
                'src'    => $isYouTube ? ($embed ?: $url) : $src,
                'mime'   => $mime,
                'raw'    => $url,
            ];
        })->values();
    @endphp

    <div class="max-w-7xl mx-auto px-4 py-6">

        {{-- En-tête (vert, boutons bleus) --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-green-800">{{ $formation->title }}</h1>
                <p class="text-sm text-green-700/80">
                    Niveau : {{ ucfirst($formation->level) }} • {{ $videos->count() }} vidéos
                </p>
            </div>

            <a href="{{ url('/mes-formations') }}"
               class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-white
                      bg-indigo-600 hover:bg-indigo-700 shadow-md transition text-sm">
                <i class="fa-solid fa-arrow-left"></i> Retour
            </a>
        </div>

        @if($videos->isEmpty())
            <div class="p-6 bg-green-50 border border-green-200 rounded-2xl text-green-800">
                Aucune vidéo n’a encore été ajoutée à cette formation.
            </div>
        @else
            {{-- Player principal (fond vert autour, boutons bleus) --}}
            <div class="rounded-3xl overflow-hidden shadow-2xl ring-1 ring-green-300/60 mb-8 bg-green-900">
                {{-- HTML5 video --}}
                <video id="player-file"
                       class="w-full aspect-video hidden bg-black"
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

                {{-- Overlay d’actions --}}
                <div class="relative">
                    <div class="absolute inset-x-0 bottom-0 flex items-center justify-between px-4 py-3
                                bg-gradient-to-t from-green-900/90 to-transparent text-white">
                        <div class="flex items-center gap-3">
                            <button id="btn-prev"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                                           bg-indigo-600 hover:bg-indigo-700 shadow transition">
                                <i class="fa-solid fa-chevron-left text-sm"></i> Précédent
                            </button>
                            <button id="btn-next"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                                           bg-indigo-600 hover:bg-indigo-700 shadow transition">
                                Suivant <i class="fa-solid fa-chevron-right text-sm"></i>
                            </button>
                        </div>
                        <div id="now-title" class="text-sm opacity-95 truncate max-w-[70%] font-medium"></div>
                    </div>
                </div>
            </div>

            {{-- Playlist (dominante verte, hover sobres) --}}
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-bold text-green-800">Contenu du cours</h2>
            </div>

            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="playlist">
                @foreach($prepared as $item)
                    <li>
                        <button
                            class="item w-full text-left group bg-white rounded-2xl border border-green-200
                                   hover:border-green-400 hover:shadow-lg overflow-hidden transition relative"
                            data-id="{{ $item['id'] }}"
                            data-title="{{ $item['title'] }}"
                            data-ordre="{{ $item['ordre'] ?? '' }}"
                            data-type="{{ $item['type'] }}"
                            data-src="{{ $item['src'] }}"
                            data-mime="{{ $item['mime'] }}"
                        >
                            <div class="relative">
                                <img src="{{ $posterUrl ?: 'https://via.placeholder.com/640x360' }}"
                                     alt="miniature" class="w-full h-40 object-cover group-hover:scale-[1.02] transition">
                                <span class="absolute bottom-2 right-2 text-[10px] px-2 py-1 rounded bg-white/90 text-green-800">
                                    Chapitre {{ $item['ordre'] ?? '-' }}
                                </span>
                                <span class="absolute top-2 left-2 text-[10px] px-2 py-1 rounded bg-green-900/80 text-white">
                                    {{ $item['type']==='youtube'
                                        ? 'YouTube'
                                        : \Illuminate\Support\Str::upper(\Illuminate\Support\Str::after($item['mime'],'/')) }}
                                </span>
                            </div>
                            <div class="p-4">
                                <p class="font-semibold text-green-900 line-clamp-2">{{ $item['title'] }}</p>
                            </div>
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- CSRF pour le marquage vu --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ⚠️ JS conservé tel quel (même logique, même IDs/classes) --}}
    <script>
        (function () {
            const items = Array.from(document.querySelectorAll('#playlist .item'));
            if (!items.length) return;

            const playerFile = document.getElementById('player-file');
            const playerYt   = document.getElementById('player-yt');
            const nowTitle   = document.getElementById('now-title');
            const btnPrev    = document.getElementById('btn-prev');
            const btnNext    = document.getElementById('btn-next');

            const videos = items.map(el => ({
                el,
                id:    +el.dataset.id,
                title: el.dataset.title,
                ordre: el.dataset.ordre ? parseInt(el.dataset.ordre,10) : null,
                type:  el.dataset.type,
                src:   el.dataset.src,
                mime:  el.dataset.mime || 'video/mp4',
            }));

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

                nowTitle.textContent = (v.ordre ? (v.ordre + '. ') : '') + v.title;

                videos.forEach((x,k) => {
                    x.el.classList.toggle('ring-2', k === index);
                    x.el.classList.toggle('ring-indigo-500', k === index); // on garde le bleu en surbrillance
                    x.el.classList.toggle('border-indigo-500', k === index);
                });

                if (v.type === 'youtube') {
                    const url = v.src.includes('?') ? (v.src + '&autoplay=1&rel=0') : (v.src + '?autoplay=1&rel=0');
                    playerYt.src = url;
                    playerYt.classList.remove('hidden');
                } else {
                    const source = document.createElement('source');
                    source.src = v.src;
                    source.type = v.mime || 'video/mp4';
                    playerFile.appendChild(source);
                    playerFile.classList.remove('hidden');
                    try { playerFile.play(); } catch (_) {}
                }
            }

            playerFile.addEventListener('ended', () => {
                const v = videos[index];
                markViewed(v.id);
                if (index < videos.length - 1) playAt(index + 1);
            });

            btnPrev.addEventListener('click', () => { if (index > 0) playAt(index - 1); });
            btnNext.addEventListener('click', () => { if (index < videos.length - 1) playAt(index + 1); });

            document.getElementById('playlist').addEventListener('click', (e) => {
                const btn = e.target.closest('.item'); if (!btn) return;
                const id = +btn.dataset.id;
                const i = videos.findIndex(x => x.id === id);
                if (i !== -1) playAt(i);
            });

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

            playAt(0);
        })();
    </script>
</x-layouts.dashboard>
