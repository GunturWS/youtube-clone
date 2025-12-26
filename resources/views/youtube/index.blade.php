@extends('layout.app')

@section('content')

<input type="hidden" id="nextPageToken" value="{{ $nextPageToken }}">
<input type="hidden" id="query" value="{{ $query }}">

<div class="px-6 py-6 bg-[#0F0F0F] min-h-screen text-white">

    @if(isset($error))
    <div class="bg-red-500/10 text-red-400 p-4 rounded-lg mb-4">
        <p class="font-semibold">YouTube API Error</p>
        <p>{{ $error }}</p>

        @if($reason === 'quotaExceeded')
            <p class="text-sm mt-1">
                Kuota YouTube API hari ini sudah habis.
            </p>
        @endif
    </div>
@endif

<x-youtube-categories />
    <div
    id="video-container"
    class="grid gap-5
           grid-cols-1
           sm:grid-cols-2
           md:grid-cols-3
           xl:grid-cols-3"
>


        @foreach ($results as $item)
            @if (isset($item['id']['kind']) && $item['id']['kind'] === 'youtube#video')

            <a
                href="{{ route('youtube.show', $item['id']['videoId']) }}"
                class="group block"
            >

                <!-- THUMBNAIL -->
                <div class="relative aspect-video rounded-xl overflow-hidden bg-[#1F1F1F]">
                    <img
                        src="{{ $item['snippet']['thumbnails']['medium']['url'] }}"
                        class="w-full h-full object-cover
                               group-hover:scale-105 transition duration-300"
                    >

                    <!-- HOVER OVERLAY -->
                    <div
                        class="absolute inset-0 bg-black/0
                               group-hover:bg-black/10 transition"
                    ></div>
                </div>

                <!-- INFO -->
                <div class="flex gap-3 mt-3">

                    <!-- CHANNEL AVATAR (DUMMY) -->
                    <div
                        class="w-9 h-9 rounded-full
                               bg-white
                               flex-shrink-0"
                    ></div>

                    <div class="min-w-0">

                        <!-- TITLE -->
                        <h3
                        class="text-sm font-medium
                        text-white
                        leading-snug
                        line-clamp-2"
                        >
                        {{ $item['snippet']['title'] }}
                    </h3>


                        <!-- CHANNEL -->
                        <p class="mt-1 text-xs text-[#AAAAAA]">
                            {{ $item['snippet']['channelTitle'] }}
                        </p>


                    </div>
                </div>

            </a>

            @endif
        @endforeach

    </div>
</div>

{{-- INFINITE SCROLL --}}
<script>
let loading = false;
let page = 1;                 // ⬅️ BATAS PAGE
const MAX_PAGE = 5;           // ⬅️ MAKSIMAL LOAD (hemat kuota)

window.addEventListener('scroll', async () => {
    if (loading || page >= MAX_PAGE) return;

    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 300) {
        loading = true;
        page++;

        const tokenEl = document.getElementById('nextPageToken');
        const queryEl = document.getElementById('query');

        if (!tokenEl || !tokenEl.value) {
            loading = false;
            return;
        }

        const token = tokenEl.value;
        const query = queryEl?.value ?? '';

        try {
            const res = await fetch(
                `/load-more?q=${encodeURIComponent(query)}&pageToken=${token}`
            );

            if (!res.ok) {
                console.error('Load more failed');
                loading = false;
                return;
            }

            const data = await res.json();

            tokenEl.value = data.nextPageToken ?? '';

            const container = document.getElementById('video-container');

            data.items.forEach(item => {
                if (!item.id || item.id.kind !== 'youtube#video') return;

                container.insertAdjacentHTML('beforeend', `
    <a href="/watch/${item.id.videoId}" class="group block">

        <div class="relative aspect-video rounded-xl overflow-hidden bg-[#1F1F1F]">
            <img
                src="${item.snippet.thumbnails.medium.url}"
                class="w-full h-full object-cover
                       group-hover:scale-105 transition duration-300"
            >
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition"></div>
        </div>

        <div class="flex gap-3 mt-3">
            <div class="w-9 h-9 rounded-full bg-[#2A2A2A] flex-shrink-0"></div>

            <div class="min-w-0">
                <h3 class="text-sm font-medium text-white leading-snug line-clamp-2">
                    ${item.snippet.title}
                </h3>
                <p class="mt-1 text-xs text-[#AAAAAA]">
                    ${item.snippet.channelTitle}
                </p>
            </div>
        </div>

    </a>
`);

            });

            // ❌ Jika tidak ada token lagi → stop
            if (!data.nextPageToken) {
                page = MAX_PAGE;
            }

        } catch (err) {
            console.error('Error load more:', err);
        }

        loading = false;
    }
});
</script>

@endsection
