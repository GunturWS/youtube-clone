@extends('layout.app')

@section('content')

<div class="px-6 py-6 bg-[#0F0F0F] min-h-screen">

    <h1 class="text-xl font-semibold mb-6">
        Subscriptions
    </h1>

    @php
        $channels = [
            ['name' => 'Fireship', 'subs' => '2.3M subscribers'],
            ['name' => 'Web Programming UNPAS', 'subs' => '1.5M subscribers'],
            ['name' => 'Traversy Media', 'subs' => '2.1M subscribers'],
            ['name' => 'Programmer Zaman Now', 'subs' => '1.2M subscribers'],
            ['name' => 'Flutter Dev', 'subs' => '800K subscribers'],
        ];
    @endphp

    <div class="space-y-3 max-w-md">

        @foreach($channels as $channel)
        <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-[#272727] transition cursor-pointer">
            <div class="w-10 h-10 rounded-full bg-[#272727]"></div>

            <div class="flex-1">
                <p class="font-medium">{{ $channel['name'] }}</p>
                <p class="text-xs text-[#AAAAAA]">{{ $channel['subs'] }}</p>
            </div>
        </div>
        @endforeach

    </div>

</div>

@endsection
