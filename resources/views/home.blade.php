@extends('layouts.app')

@section('content')
<div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @for ($i = 1; $i <= 12; $i++)
        <div>
            <div class="aspect-video bg-gray-200 rounded-xl mb-3"></div>
            <h3 class="font-semibold text-sm leading-snug">
                Judul Video {{ $i }}
            </h3>
            <p class="text-xs text-gray-600">
                Nama Channel • 1.2M views
            </p>
        </div>
    @endfor
</div>
@endsection
