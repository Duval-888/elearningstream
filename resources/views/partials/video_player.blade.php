@php
    use Illuminate\Support\Str;

    /** @var \App\Models\Video $video */
    $url = $video->video_url ?? '';
    $isYouTube = preg_match('/(youtube\.com|youtu\.be)/i', $url);

    // Build embed pour YouTube (watch?v= / youtu.be / shorts)
    $embedUrl = null;
    if ($isYouTube) {
        if (Str::contains($url, 'watch?v=')) {
            $embedUrl = Str::replace('watch?v=', 'embed/', $url);
        } elseif (Str::contains($url, 'youtu.be/')) {
            $id = Str::after($url, 'youtu.be/');
            $id = Str::before($id, '?');
            $embedUrl = 'https://www.youtube.com/embed/' . trim($id, '/');
        } elseif (Str::contains($url, '/shorts/')) {
            $id = Str::after($url, '/shorts/');
            $id = Str::before($id, '?');
            $embedUrl = 'https://www.youtube.com/embed/' . trim($id, '/');
        }
    }

    // Source fichier local / externe
    $src = $url;
    if (!$isYouTube && $src && !Str::startsWith($src, ['http://','https://','//'])) {
        // Ex. "/storage/videos/xxx.mp4" ou "videos/xxx.mkv"
        $src = asset($src);
    }

    // MIME type: prends la colonne si dispo, sinon devine par extension
    $mime = $video->mime_type ?? null;
    if (!$mime && $src) {
        $lower = Str::lower($src);
        $mime = match (true) {
            Str::endsWith($lower, '.mp4')  => 'video/mp4',
            Str::endsWith($lower, '.webm') => 'video/webm',
            Str::endsWith($lower, ['.ogg', '.ogv']) => 'video/ogg',
            Str::endsWith($lower, '.mkv')  => 'video/x-matroska',
            Str::endsWith($lower, '.avi')  => 'video/x-msvideo',
            Str::endsWith($lower, ['.mov'])=> 'video/quicktime',
            Str::endsWith($lower, ['.m4v'])=> 'video/x-m4v',
            default => 'video/mp4',
        };
    }
@endphp

@if($isYouTube && $embedUrl)
    <div class="w-full aspect-video rounded-lg overflow-hidden bg-black">
        <iframe
            src="{{ $embedUrl }}"
            class="w-full h-full"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen>
        </iframe>
    </div>
@else
    <video controls preload="metadata" class="w-full rounded-lg bg-black">
        <source src="{{ $src }}" type="{{ $mime ?? 'video/mp4' }}">
        Votre navigateur ne supporte pas ce format.
        @if(($mime && !Str::contains($mime, ['mp4','webm','ogg'])) || Str::endsWith(Str::lower($src), ['.mkv','.avi']))
            Essayez un autre navigateur ou convertissez la vidéo en MP4 (H.264/AAC) pour une compatibilité maximale.
        @endif
    </video>
@endif
