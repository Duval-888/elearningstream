<style>
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-hover:hover {
        transform: scale(1.05);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15);
    }

    .card-header h5 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-badge {
        font-size: 0.75rem;
        background-color: rgba(255, 255, 255, 0.2);
        color: #fff;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        margin-left: auto;
    }
</style>

<div class="card card-hover border-0 h-100">
    <div class="card-header bg-{{ $color ?? 'primary' }} text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            {!! $icon ?? '' !!} {{ $title }}
        </h5>
        @if(isset($badge))
            <span class="card-badge">{{ $badge }}</span>
        @endif
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
