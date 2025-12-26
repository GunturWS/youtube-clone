@extends('layout.app')

@section('content')
<div class="px-6 py-6 bg-nova-dark min-h-screen text-nova-milk">
    <div class="grid grid-cols-12 gap-6">

        <!-- MAIN VIDEO -->
        <div class="col-span-12 lg:col-span-8">

            <!-- Player -->
            <div class="aspect-video bg-black rounded-2xl overflow-hidden shadow-lg">
                <iframe
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/{{ $video['id'] }}"
                    allowfullscreen>
                </iframe>
            </div>

            <!-- Title -->
            <h1 class="mt-4 text-xl text-[#e7d7ad] font-semibold leading-snug">
                {{ $video['snippet']['title'] }}
            </h1>

            <!-- Channel -->
            <div class="mt-2 text-sm  text-[#98971a]">
                {{ $video['snippet']['channelTitle'] }}
            </div>

            <!-- Description -->
            <div class="mt-4 bg-[#2e2e2e] text-[#e7d7ad] rounded-xl p-4 text-sm text-nova-milk/90 whitespace-pre-line">
                {{ $video['snippet']['description'] }}
            </div>

        </div>

        <!-- SIDEBAR RECOMMENDED -->
        <div class="col-span-12 lg:col-span-4 space-y-4">

            @foreach ($related as $item)
                <a
                    href="{{ route('youtube.show', $item['id']['videoId']) }}"
                    class="flex gap-3 group rounded-xl p-2 hover:bg-[#2e2e2e] transition"
                >

                    <!-- Thumbnail -->
                    <div class="w-40 aspect-video rounded-lg overflow-hidden bg-black flex-shrink-0">
                        <img
                            src="{{ $item['snippet']['thumbnails']['medium']['url'] }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>

                    <!-- Info -->
                    <div class="flex flex-col gap-1">
                        <p class="text-sm font-semibold line-clamp-2 text-[#e7d7ad] group-hover:text-nova-yellow transition">
                            {{ $item['snippet']['title'] }}
                        </p>

                        <p class="text-xs text-[#98971a]">
                            {{ $item['snippet']['channelTitle'] }}
                        </p>
                    </div>

                </a>
            @endforeach

        </div>

    </div>
</div>
@endsection
