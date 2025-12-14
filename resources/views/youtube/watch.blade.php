@extends('layout.app')

@section('content')
<div class="px-6 py-6">
    <div class="grid grid-cols-12 gap-6">

        <!-- VIDEO PLAYER -->
        <div class="col-span-8">

            <!-- Player -->
            <div class="aspect-video bg-black rounded-xl overflow-hidden">
                <iframe
    class="w-full h-full"
    src="https://www.youtube.com/embed/{{ $videoId }}"
    frameborder="0"
    allowfullscreen>
</iframe>

            </div>

            <!-- Title -->
            <h1 class="mt-4 text-lg font-semibold leading-snug">
                Judul Video YouTube (Dummy Dulu)
            </h1>

            <!-- Channel & Action -->
            <div class="mt-3 flex items-center justify-between">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-300"></div>
                    <div>
                        <p class="text-sm font-medium">Nama Channel</p>
                        <p class="text-xs text-gray-500">1,2 jt subscriber</p>
                    </div>
                </div>

                <button class="px-4 py-2 bg-black text-white rounded-full text-sm">
                    Subscribe
                </button>
            </div>

            <!-- Description -->
            <div class="mt-4 bg-gray-100 rounded-xl p-4 text-sm text-gray-700">
                Deskripsi video akan muncul di sini.  
                Ini masih dummy supaya fokus ke layout dulu.
            </div>

        </div>

        <!-- SIDEBAR RECOMMENDED -->
        <div class="col-span-4 space-y-4">

            @for ($i = 0; $i < 8; $i++)
            <div class="flex gap-3 cursor-pointer">

                <div class="w-40 aspect-video bg-gray-200 rounded-lg overflow-hidden">
                    <img
                        src="https://picsum.photos/320/180?random={{ $i }}"
                        class="w-full h-full object-cover"
                    >
                </div>

                <div>
                    <p class="text-sm font-semibold line-clamp-2">
                        Video Rekomendasi Mirip YouTube
                    </p>
                    <p class="text-xs text-gray-600 mt-1">Nama Channel</p>
                    <p class="text-xs text-gray-500">
                        500 rb x ditonton
                    </p>
                </div>

            </div>
            @endfor

        </div>

    </div>
</div>
@endsection
