@extends('layout.app')

@section('content')

<div class="px-6 py-6 bg-[#0F0F0F] min-h-screen">

    <!-- TITLE -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-white flex items-center gap-2">
            🔥 Trending di Indonesia
        </h1>
        <p class="text-sm text-[#AAAAAA] mt-1">
            Video terpopuler saat ini
        </p>
    </div>

    <!-- GRID -->
    <div
        class="grid gap-6
               grid-cols-1
               sm:grid-cols-2
               md:grid-cols-3
               xl:grid-cols-3"
    >

        @forelse ($results as $video)

            @if (isset($video['id']))

            <a
                href="{{ route('youtube.show', $video['id']) }}"
                class="group block"
            >

                <!-- THUMBNAIL -->
                <div class="relative aspect-video rounded-xl overflow-hidden bg-[#181818]">
                    <img
                        src="{{ $video['snippet']['thumbnails']['medium']['url'] }}"
                        alt="{{ $video['snippet']['title'] }}"
                        class="w-full h-full object-cover
                               group-hover:scale-105 transition duration-300"
                    >

                    <div
                        class="absolute inset-0
                               bg-black/0
                               group-hover:bg-black/20 transition"
                    ></div>
                </div>

                <!-- INFO -->
                <div class="flex gap-3 mt-3">

                    <div
                        class="w-9 h-9 rounded-full
                               bg-[#272727]
                               flex-shrink-0"
                    ></div>

                    <div class="min-w-0">

                        <h3
                            class="text-sm font-semibold
                                   text-white
                                   leading-snug
                                   line-clamp-2"
                        >
                            {{ $video['snippet']['title'] }}
                        </h3>

                        <p class="mt-1 text-xs text-[#AAAAAA]">
                            {{ $video['snippet']['channelTitle'] }}
                        </p>

                        <p class="mt-0.5 text-xs text-[#717171]">
                            {{ \Carbon\Carbon::parse($video['snippet']['publishedAt'])->diffForHumans() }}
                        </p>

                    </div>
                </div>

            </a>

            @endif

        @empty
            <p class="text-[#AAAAAA] col-span-full">
                Tidak ada data trending saat ini.
            </p>
        @endforelse

    </div>
</div>

@endsection
