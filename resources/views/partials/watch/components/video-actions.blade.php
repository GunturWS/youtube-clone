<!-- Video Stats & Actions -->
<div class="mt-3 flex flex-wrap items-center justify-between gap-4">
    
    <!-- Channel Info -->
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-[#98971a] flex items-center justify-center text-white font-bold">
            {{ substr($video['snippet']['channelTitle'], 0, 1) }}
        </div>
        <div>
            <p class="font-semibold text-[#e7d7ad]">{{ $video['snippet']['channelTitle'] }}</p>
            <p class="text-xs text-nova-milk/70">
                {{ number_format($video['statistics']['subscriberCount'] ?? 0) }} subscribers
            </p>
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
                class="px-4 py-2 rounded-full font-semibold text-sm transition-all duration-300 flex items-center gap-2"
            >
                @if(auth()->user()->isSubscribedTo($video['snippet']['channelId']))
                    <i class="fas fa-check"></i>
                    <span>Subscribed</span>
                @else
                    <i class="fas fa-bell"></i>
                    <span>Subscribe</span>
                @endif
            </button>
        @else
            <a 
                href="{{ route('login') }}"
                class="px-4 py-2 rounded-full bg-[#2e2e2e] text-[#e7d7ad] hover:bg-red-600 hover:text-white font-semibold text-sm transition flex items-center gap-2"
            >
                <i class="fas fa-bell"></i>
                <span>Subscribe</span>
            </a>
        @endauth

        <!-- LIKE/DISLIKE BUTTONS -->
        <div class="flex items-center bg-[#2e2e2e] rounded-full">
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

<!-- JavaScript untuk subscription -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const subscribeBtn = document.getElementById('subscribeBtn');
    
    if (subscribeBtn) {
        subscribeBtn.addEventListener('click', function() {
            const channelId = this.dataset.channelId;
            const channelName = this.dataset.channelName;
            
            fetch('{{ route("subscribe.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    channel_id: channelId,
                    channel_name: channelName
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button appearance
                    if (data.subscribed) {
                        subscribeBtn.innerHTML = `
                            <i class="fas fa-check"></i>
                            <span>Subscribed</span>
                        `;
                        subscribeBtn.classList.add('bg-red-600', 'text-white');
                        subscribeBtn.classList.remove('bg-[#2e2e2e]', 'text-[#e7d7ad]');
                    } else {
                        subscribeBtn.innerHTML = `
                            <i class="fas fa-bell"></i>
                            <span>Subscribe</span>
                        `;
                        subscribeBtn.classList.remove('bg-red-600', 'text-white');
                        subscribeBtn.classList.add('bg-[#2e2e2e]', 'text-[#e7d7ad]');
                    }
                    
                    // Show notification
                    showNotification(
                        data.subscribed 
                            ? `Subscribed to ${channelName}` 
                            : `Unsubscribed from ${channelName}`
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error updating subscription', 'error');
            });
        });
    }
});

// Notification function
function showNotification(message, type = 'success') {
    // Buat elemen notifikasi
    const notification = document.createElement('div');
    notification.className = `fixed bottom-4 right-4 px-4 py-3 rounded-lg shadow-lg z-50 ${
        type === 'error' ? 'bg-red-600' : 'bg-green-600'
    } text-white`;
    notification.textContent = message;
    
    // Tambahkan ke body
    document.body.appendChild(notification);
    
    // Hapus setelah 3 detik
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>