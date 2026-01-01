@extends('layout.app')

@section('content')
<div class="px-6 py-6 bg-nova-dark min-h-screen text-nova-milk">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-[#e7d7ad] mb-2">Subscription Feed</h1>
        <p class="text-nova-milk/70">Latest videos from channels you're subscribed to</p>
    </div>
    
    @if($subscriptions->count() > 0)
        <!-- Tabs for channels -->
        <div class="mb-6">
            <div class="flex space-x-2 overflow-x-auto pb-2">
                <a 
                    href="{{ route('youtube.subscriptions') }}"
                    class="px-4 py-2 rounded-lg whitespace-nowrap {{ !$selectedChannelId ? 'bg-red-600 text-white' : 'bg-[#2e2e2e] text-nova-milk hover:bg-[#3a3a3a]' }}"
                >
                    All Subscriptions
                </a>
                
                @foreach($subscriptions as $subscription)
                    <a 
                        href="{{ route('youtube.subscriptions', ['channel_id' => $subscription->channel_id]) }}"
                        class="px-4 py-2 rounded-lg whitespace-nowrap {{ $selectedChannelId == $subscription->channel_id ? 'bg-red-600 text-white' : 'bg-[#2e2e2e] text-nova-milk hover:bg-[#3a3a3a]' }}"
                    >
                        {{ $subscription->channel_name }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <!-- Videos Grid -->
        @if(count($videos) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($videos as $video)
                    <div class="bg-[#2e2e2e] rounded-xl overflow-hidden hover:bg-[#3a3a3a] transition group">
                        <a href="{{ route('youtube.show', $video['id']['videoId']) }}">
                            <!-- Thumbnail -->
                            <div class="aspect-video relative overflow-hidden">
                                <img 
                                    src="{{ $video['snippet']['thumbnails']['medium']['url'] }}" 
                                    alt="{{ $video['snippet']['title'] }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                >
                            </div>
                            
                            <!-- Info -->
                            <div class="p-3">
                                <h3 class="font-semibold text-[#e7d7ad] line-clamp-2 mb-2 group-hover:text-red-400 transition">
                                    {{ $video['snippet']['title'] }}
                                </h3>
                                
                                <div class="flex items-center gap-2 mb-1">
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs">
                                        {{ substr($video['snippet']['channelTitle'], 0, 1) }}
                                    </div>
                                    <span class="text-xs text-[#98971a] truncate">
                                        {{ $video['snippet']['channelTitle'] }}
                                    </span>
                                </div>
                                
                                <p class="text-xs text-nova-milk/60">
                                    Published {{ \Carbon\Carbon::parse($video['snippet']['publishedAt'])->diffForHumans() }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Videos -->
            <div class="text-center py-12 bg-[#2e2e2e] rounded-xl">
                <i class="fas fa-video-slash text-4xl text-nova-milk/30 mb-3"></i>
                <p class="text-nova-milk/70">No videos found from this channel</p>
            </div>
        @endif
        
    @else
        <!-- No Subscriptions -->
        <div class="text-center py-12 bg-[#2e2e2e] rounded-xl">
            <i class="fas fa-bell-slash text-4xl text-nova-milk/30 mb-3"></i>
            <h3 class="text-lg font-semibold text-[#e7d7ad] mb-2">No subscriptions yet</h3>
            <p class="text-nova-milk/70 mb-4">Subscribe to channels to see their latest videos here</p>
            <a 
                href="{{ route('youtube.index') }}" 
                class="inline-block px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition"
            >
                <i class="fas fa-search mr-2"></i>Explore Videos
            </a>
        </div>
    @endif
    
</div>
@endsection