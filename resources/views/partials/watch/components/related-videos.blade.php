<!-- SIDEBAR RECOMMENDED -->
<div class="col-span-12 lg:col-span-4 space-y-4">
    <h3 class="text-lg font-semibold text-[#e7d7ad]">Recommended Videos</h3>

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
                
                <p class="text-xs text-nova-milk/60">
                    {{ number_format($item['statistics']['viewCount'] ?? rand(1000, 1000000)) }} views
                </p>
            </div>

        </a>
    @endforeach

</div>