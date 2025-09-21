{{-- resources/views/formations/watch.blade.php --}}
<x-layouts.dashboard>
    @php
        $posterUrl = isset($formation->cover_image) && $formation->cover_image
            ? (\Illuminate\Support\Str::startsWith($formation->cover_image, ['http://','https://'])
                ? $formation->cover_image
                : asset('storage/'.$formation->cover_image))
            : '';

        // Données pour le JS
        $jsVideos = $videos->map(fn($v) => [
            'id' => $v->id,
            'title' => $v->title,
            'url' => $v->video_url,
            'ordre' => $v->ordre,
        ])->values();
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
            {{-- Player principal --}}
            <div class="bg-black rounded-2xl overflow-hidden shadow-xl relative mb-6">
                {{-- MP4 --}}
                <video id="player-mp4"
                       class="w-full aspect-video hidden"
                       poster="{{ $posterUrl }}"
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
                @foreach($videos as $v)
                    <li>
                        <button class="w-full text-left group bg-white rounded-xl border hover:border-indigo-300 hover:shadow-md overflow-hidden transition relative item"
                                data-id="{{ $v->id }}"
                                data-title="{{ $v->title }}"
                                data-url="{{ $v->video_url }}"
                                data-ordre="{{ $v->ordre ?? '' }}">
                            <div class="relative">
                                <img src="{{ $posterUrl ?: 'https://via.placeholder.com/640x360' }}"
                                     alt="miniature" class="w-full h-36 object-cover">
                                <span class="absolute bottom-2 right-2 text-[10px] px-2 py-1 rounded bg-white/80 text-gray-900">
                                    Chapitre {{ $v->ordre ?? '-' }}
                                </span>
                                <span class="absolute top-2 left-2 text-[10px] px-2 py-1 rounded bg-black/70 text-white">
                                    {{ preg_match('/(youtube\.com|youtu\.be)/i', $v->video_url) ? 'YouTube' : 'MP4' }}
                                </span>
                            </div>
                            <div class="p-3">
                                <p class="font-medium text-gray-900 line-clamp-2">{{ $v->title }}</p>
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
            const videos = @json($jsVideos);
            if (!Array.isArray(videos) || videos.length === 0) return;

            const playerMp4 = document.getElementById('player-mp4');
            const playerYt  = document.getElementById('player-yt');
            const nowTitle  = document.getElementById('now-title');
            const playlist  = document.getElementById('playlist');
            const btnPrev   = document.getElementById('btn-prev');
            const btnNext   = document.getElementById('btn-next');

            let index = 0;

            function isYouTube(url) { return /(youtube\.com|youtu\.be)/i.test(url || ''); }
            function ytEmbed(url) {
                try {
                    const u = new URL(url);
                    if (u.hostname.includes('youtu.be')) return `https://www.youtube.com/embed/${u.pathname.replace('/', '')}?autoplay=1&rel=0`;
                    if (u.pathname.startsWith('/shorts/')) return `https://www.youtube.com/embed/${u.pathname.split('/')[2]}?autoplay=1&rel=0`;
                    const id = u.searchParams.get('v'); return `https://www.youtube.com/embed/${id}?autoplay=1&rel=0`;
                } catch { return ''; }
            }
            function markViewed(videoId) {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch(`/videos/${videoId}/vue`, { method: 'POST', headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' } }).catch(()=>{});
            }
            function stopAll() {
                playerMp4.pause?.(); playerMp4.classList.add('hidden'); playerMp4.removeAttribute('src');
                playerYt.classList.add('hidden'); playerYt.removeAttribute('src');
            }
            function playAt(i) {
                if (i < 0 || i >= videos.length) return;
                index = i;
                const v = videos[index];
                nowTitle.textContent = (v.ordre ? (v.ordre + '. ') : '') + v.title;

                stopAll();

                if (isYouTube(v.url)) { playerYt.src = ytEmbed(v.url); playerYt.classList.remove('hidden'); }
                else { playerMp4.src = v.url; playerMp4.classList.remove('hidden'); playerMp4.play?.(); }

                document.querySelectorAll('#playlist .item').forEach((el, k) => {
                    el.classList.toggle('ring-2', k === index);
                    el.classList.toggle('ring-indigo-500', k === index);
                    el.classList.toggle('border-indigo-500', k === index);
                });
            }

            playerMp4.addEventListener('ended', () => { markViewed(videos[index].id); if (index < videos.length - 1) playAt(index + 1); });
            btnPrev.addEventListener('click', () => { if (index > 0) playAt(index - 1); });
            btnNext.addEventListener('click', () => { if (index < videos.length - 1) playAt(index + 1); });

            if (playlist) {
                playlist.addEventListener('click', (e) => {
                    const btn = e.target.closest('.item'); if (!btn) return;
                    const id = +btn.dataset.id;
                    const i = videos.findIndex(x => x.id === id);
                    if (i !== -1) playAt(i);
                });
            }

            window.addEventListener('keydown', (e) => {
                if (['INPUT','TEXTAREA'].includes(document.activeElement.tagName)) return;
                if (e.key === 'ArrowRight') { e.preventDefault(); btnNext.click(); }
                if (e.key === 'ArrowLeft')  { e.preventDefault(); btnPrev.click(); }
                if (e.code === 'Space')     { e.preventDefault(); if (!playerMp4.classList.contains('hidden')) { if (playerMp4.paused) playerMp4.play(); else playerMp4.pause(); } }
            });

            playAt(0);
        })();
    </script>
</x-layouts.dashboard>
