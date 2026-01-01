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

// Load subscription status on page load
document.addEventListener('DOMContentLoaded', function() {
    // For logged in users, check subscription status
    @if(auth()->check())
        const subscribeBtn = document.getElementById('subscribeBtn');
        if (subscribeBtn) {
            const channelId = subscribeBtn.dataset.channelId;
            
            fetch(`/subscription/check/${channelId}`)
                .then(response => response.json())
                .then(data => {
                    // Data akan di-handle oleh Alpine.js
                })
                .catch(error => console.error('Error checking subscription:', error));
        }
    @endif
});
</script>