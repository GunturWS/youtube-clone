@extends('layout.app')

@section('content')
<div class="px-6 py-6">
    <div class="grid gap-6
        grid-cols-1
        sm:grid-cols-2
        md:grid-cols-3
        xl:grid-cols-4">

@for ($i = 0; $i < 12; $i++)
<a href="/watch/{{ $i }}" class="group cursor-pointer block">
    <!-- Thumbnail -->
    <div class="relative aspect-video bg-gray-200 rounded-xl overflow-hidden">
        <img
            src="https://picsum.photos/400/225?random={{ $i }}"
            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
        >

        <span class="absolute bottom-2 right-2 bg-black/80 text-white text-xs px-1.5 py-0.5 rounded">
            12:34
        </span>
    </div>

    <!-- Info -->
    <div class="flex gap-3 mt-3">
        <div class="w-9 h-9 rounded-full bg-gray-300 flex-shrink-0"></div>

        <div>
            <h3 class="text-sm font-semibold leading-snug line-clamp-2">
                Judul Video YouTube yang Panjang Supaya Mirip Asli Banget
            </h3>
            <p class="text-sm text-gray-600 mt-1">Nama Channel</p>
            <p class="text-xs text-gray-500">
                1,2 jt kali ditonton • 2 hari lalu
            </p>
        </div>
    </div>
</a>
@endfor


    </div>
</div>
@endsection
