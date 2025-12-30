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
                    src="https://www.youtube.com/embed/{{ $video['id'] }}?autoplay=1"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>

            <!-- Title -->
            <h1 class="mt-4 text-xl text-[#e7d7ad] font-semibold leading-snug">
                {{ $video['snippet']['title'] }}
            </h1>

            <!-- Video Stats & Actions -->
            <div class="mt-3 flex flex-wrap items-center justify-between gap-4">
                
                <!-- Channel Info -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#98971a] flex items-center justify-center text-white font-bold">
                        {{ substr($video['snippet']['channelTitle'], 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-[#e7d7ad]">{{ $video['snippet']['channelTitle'] }}</p>
                        <p class="text-xs text-nova-milk/70">{{ number_format($video['statistics']['subscriberCount'] ?? 0) }} subscribers</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3" id="videoActions">
                    
                    <!-- SUBSCRIBE BUTTON -->
                    @auth
                        <button 
                            id="subscribeBtn"
                            data-channel-id="{{ $video['snippet']['channelId'] }}"
                            data-channel-name="{{ $video['snippet']['channelTitle'] }}"
                            class="px-4 py-2 rounded-full font-semibold text-sm transition-all duration-300 {{ auth()->user()->hasSubscribed($video['snippet']['channelId']) ? 'bg-red-600 text-white' : 'bg-[#2e2e2e] text-[#e7d7ad] hover:bg-red-600 hover:text-white' }}"
                        >
                            <span id="subscribeText">
                                {{ auth()->user()->hasSubscribed($video['snippet']['channelId']) ? 'Subscribed ✓' : 'Subscribe' }}
                            </span>
                            <span id="subscriberCount" class="ml-1">
                                {{ number_format($video['statistics']['subscriberCount'] ?? 0) }}
                            </span>
                        </button>
                    @else
                        <a 
                            href="{{ route('login') }}"
                            class="px-4 py-2 rounded-full bg-[#2e2e2e] text-[#e7d7ad] hover:bg-red-600 hover:text-white font-semibold text-sm transition"
                        >
                            Subscribe {{ number_format($video['statistics']['subscriberCount'] ?? 0) }}
                        </a>
                    @endauth

                    <!-- LIKE/DISLIKE BUTTONS -->
                    <div class="flex items-center bg-[#2e2e2e] rounded-full p-1">
                        <!-- LIKE -->
                        @auth
                            <button 
                                id="likeBtn"
                                data-video-id="{{ $video['id'] }}"
                                class="flex items-center gap-2 px-4 py-2 rounded-l-full hover:bg-[#3a3a3a] transition {{ auth()->user()->hasLiked($video['id']) ? 'text-blue-500' : 'text-nova-milk' }}"
                            >
                                <i class="fas fa-thumbs-up"></i>
                                <span id="likeCount">{{ number_format($video['statistics']['likeCount'] ?? 0) }}</span>
                            </button>
                        @else
                            <a 
                                href="{{ route('login') }}"
                                class="flex items-center gap-2 px-4 py-2 rounded-l-full hover:bg-[#3a3a3a] transition text-nova-milk"
                            >
                                <i class="fas fa-thumbs-up"></i>
                                <span>{{ number_format($video['statistics']['likeCount'] ?? 0) }}</span>
                            </a>
                        @endauth

                        <!-- SEPARATOR -->
                        <div class="w-px h-6 bg-nova-milk/20"></div>

                        <!-- DISLIKE -->
                        @auth
                            <button 
                                id="dislikeBtn"
                                data-video-id="{{ $video['id'] }}"
                                class="flex items-center gap-2 px-4 py-2 rounded-r-full hover:bg-[#3a3a3a] transition text-nova-milk"
                            >
                                <i class="fas fa-thumbs-down"></i>
                                <span id="dislikeCount">{{ number_format($video['statistics']['dislikeCount'] ?? 0) }}</span>
                            </button>
                        @else
                            <a 
                                href="{{ route('login') }}"
                                class="flex items-center gap-2 px-4 py-2 rounded-r-full hover:bg-[#3a3a3a] transition text-nova-milk"
                            >
                                <i class="fas fa-thumbs-down"></i>
                                <span>{{ number_format($video['statistics']['dislikeCount'] ?? 0) }}</span>
                            </a>
                        @endauth
                    </div>

                    <!-- VIEW COUNT -->
                    <div class="text-sm text-nova-milk/70">
                        <i class="fas fa-eye mr-1"></i>
                        {{ number_format($video['statistics']['viewCount'] ?? 0) }} views
                    </div>

                </div>

            </div>

            <!-- Description -->
            <div class="mt-6 bg-[#2e2e2e] text-[#e7d7ad] rounded-xl p-4 text-sm whitespace-pre-line">
                <div class="font-semibold mb-2">Description</div>
                {{ $video['snippet']['description'] }}
                
                <!-- Published Date -->
                <div class="mt-4 pt-4 border-t border-nova-milk/10 text-xs text-nova-milk/60">
                    Published on {{ \Carbon\Carbon::parse($video['snippet']['publishedAt'])->format('F j, Y') }}
                </div>
            </div>

        </div>

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

    </div>
</div>

@push('scripts')
<script>
// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ========== LIKE/UNLIKE FUNCTIONALITY ==========
const likeBtn = document.getElementById('likeBtn');
if (likeBtn) {
    likeBtn.addEventListener('click', function() {
        const videoId = this.dataset.videoId;
        
        fetch('{{ route("like.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                video_id: videoId 
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Update like button appearance
            if (data.liked) {
                likeBtn.classList.add('text-blue-500');
                likeBtn.classList.remove('text-nova-milk');
            } else {
                likeBtn.classList.remove('text-blue-500');
                likeBtn.classList.add('text-nova-milk');
            }
            
            // Update like count
            document.getElementById('likeCount').textContent = 
                new Intl.NumberFormat().format(data.total_likes);
                
            // Show notification
            showNotification(data.liked ? 'Video liked!' : 'Like removed');
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating like', 'error');
        });
    });
}

// ========== SUBSCRIBE/UNSUBSCRIBE FUNCTIONALITY ==========
const subscribeBtn = document.getElementById('subscribeBtn');
if (subscribeBtn) {
    subscribeBtn.addEventListener('click', function() {
        const channelId = this.dataset.channelId;
        const channelName = this.dataset.channelName;
        
        fetch('{{ route("subscribe.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                channel_id: channelId 
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Update subscribe button appearance
            if (data.subscribed) {
                subscribeBtn.classList.add('bg-red-600', 'text-white');
                subscribeBtn.classList.remove('bg-[#2e2e2e]', 'text-[#e7d7ad]');
                document.getElementById('subscribeText').textContent = 'Subscribed ✓';
            } else {
                subscribeBtn.classList.remove('bg-red-600', 'text-white');
                subscribeBtn.classList.add('bg-[#2e2e2e]', 'text-[#e7d7ad]');
                document.getElementById('subscribeText').textContent = 'Subscribe';
            }
            
            // Update subscriber count
            document.getElementById('subscriberCount').textContent = 
                new Intl.NumberFormat().format(data.total_subscribers);
                
            // Show notification
            showNotification(
                data.subscribed 
                    ? `Subscribed to ${channelName}` 
                    : `Unsubscribed from ${channelName}`
            );
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating subscription', 'error');
        });
    });
}

// ========== DISLIKE FUNCTIONALITY ==========
const dislikeBtn = document.getElementById('dislikeBtn');
if (dislikeBtn) {
    dislikeBtn.addEventListener('click', function() {
        const videoId = this.dataset.videoId;
        
        // Note: YouTube API v3 tidak support dislike count lagi
        // Ini hanya untuk UI demonstration
        showNotification('Dislike recorded (demo)', 'info');
        
        // Optional: Implement your own dislike system
        // fetch('/dislike/toggle', { ... })
    });
}

// ========== NOTIFICATION FUNCTION ==========
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 ${
        type === 'error' ? 'bg-red-600' : 
        type === 'info' ? 'bg-blue-600' : 'bg-green-600'
    } text-white`;
    notification.textContent = message;
    
    // Add to body
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// ========== TRACK VIEW COUNT ==========
// Increment view count when video loads
window.addEventListener('load', function() {
    const videoId = '{{ $video["id"] }}';
    
    // Send view count to server
    fetch('/api/video/view', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ video_id: videoId })
    }).catch(error => console.error('View count error:', error));
});
</script>
@endpush
@endsection