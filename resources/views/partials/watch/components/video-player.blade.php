<!-- Player -->
<div class="aspect-video bg-black rounded-2xl overflow-hidden shadow-lg">
    @if(isset($video['id']) && $video['id'])
        <iframe
            class="w-full h-full"
            src="https://www.youtube.com/embed/{{ $video['id'] }}?autoplay=1&rel=0&modestbranding=1"
            title="{{ $video['snippet']['title'] ?? 'YouTube Video' }}"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>
    @else
        <div class="w-full h-full flex items-center justify-center bg-gray-900 text-white">
            <div class="text-center">
                <i class="fas fa-exclamation-triangle text-4xl mb-3"></i>
                <p class="text-lg font-semibold">Video tidak tersedia</p>
                <p class="text-sm opacity-75 mt-1">Video mungkin dihapus atau diprivate</p>
            </div>
        </div>
    @endif
</div>

<!-- Title -->
<h1 class="mt-4 text-xl text-[#e7d7ad] font-semibold leading-snug">
    {{ $video['snippet']['title'] ?? 'Video Title Not Available' }}
</h1>