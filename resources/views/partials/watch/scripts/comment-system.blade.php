<script>
// ========== COMMENT SYSTEM ==========
let currentCommentPage = 1;
let loadingComments = false;
let hasMoreComments = true;

// Auto-resize textarea
function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = (textarea.scrollHeight) + 'px';
}

// Format tanggal
function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);
    
    const intervals = [
        { label: 'year', seconds: 31536000 },
        { label: 'month', seconds: 2592000 },
        { label: 'week', seconds: 604800 },
        { label: 'day', seconds: 86400 },
        { label: 'hour', seconds: 3600 },
        { label: 'minute', seconds: 60 },
        { label: 'second', seconds: 1 }
    ];
    
    for (let interval of intervals) {
        const count = Math.floor(seconds / interval.seconds);
        if (count >= 1) {
            return count === 1 ? `1 ${interval.label} ago` : `${count} ${interval.label}s ago`;
        }
    }
    
    return 'just now';
}

// Buat elemen komentar
function createCommentElement(comment) {
    const div = document.createElement('div');
    div.className = 'bg-[#2e2e2e] rounded-xl p-4 comment-item';
    div.dataset.commentId = comment.id;
    
    const userInitial = comment.user ? comment.user.name.charAt(0).toUpperCase() : 'U';
    const userName = comment.user ? comment.user.name : 'Unknown User';
    const timeAgo = formatTimeAgo(comment.created_at);
    
    div.innerHTML = `
        <div class="flex gap-3">
            <!-- User Avatar -->
            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold flex-shrink-0">
                ${userInitial}
            </div>
            
            <!-- Comment Content -->
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <span class="font-semibold text-[#e7d7ad]">${userName}</span>
                    <span class="text-xs text-nova-milk/60">${timeAgo}</span>
                </div>
                
                <p class="text-nova-milk/90 mb-2">${comment.content}</p>
                
                <!-- Action Buttons -->
                <div class="flex items-center gap-4 text-sm">
                    <button class="text-nova-milk/70 hover:text-nova-yellow transition flex items-center gap-1" onclick="toggleLikeComment(${comment.id})">
                        <i class="far fa-thumbs-up"></i>
                        <span>${comment.likes_count}</span>
                    </button>
                    
                    <button class="text-nova-milk/70 hover:text-nova-yellow transition flex items-center gap-1" onclick="showReplyForm(${comment.id})">
                        <i class="far fa-comment"></i>
                        <span>Reply</span>
                    </button>
                    
                    ${comment.user_id === {{ auth()->id() ?? 0 }} ? `
                    <button class="text-nova-milk/70 hover:text-red-400 transition ml-auto" onclick="deleteComment(${comment.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                    ` : ''}
                </div>
                
                <!-- Reply Form (Hidden) -->
                <div id="replyForm-${comment.id}" class="mt-3 hidden">
                    <form onsubmit="submitReply(event, ${comment.id})" class="flex gap-2">
                        <input type="text" 
                            id="replyInput-${comment.id}"
                            class="flex-1 bg-[#1a1a1a] border border-nova-milk/20 rounded-lg px-3 py-2 text-nova-milk focus:outline-none focus:ring-2 focus:ring-nova-yellow"
                            placeholder="Write a reply..."
                            required>
                        <button type="submit" class="px-3 py-2 bg-nova-yellow text-nova-dark rounded-lg hover:bg-yellow-600">
                            Reply
                        </button>
                        <button type="button" onclick="hideReplyForm(${comment.id})" class="px-3 py-2 bg-[#3a3a3a] rounded-lg">
                            Cancel
                        </button>
                    </form>
                </div>
                
                <!-- Replies List -->
                ${comment.replies && comment.replies.length > 0 ? `
                <div class="mt-3 pl-4 border-l-2 border-nova-milk/20 space-y-3">
                    ${comment.replies.map(reply => `
                    <div class="flex gap-2">
                        <div class="w-6 h-6 rounded-full bg-gradient-to-r from-green-500 to-blue-500 flex items-center justify-center text-white text-xs flex-shrink-0">
                            ${reply.user ? reply.user.name.charAt(0).toUpperCase() : 'U'}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-medium text-[#e7d7ad] text-sm">${reply.user ? reply.user.name : 'Unknown'}</span>
                                <span class="text-xs text-nova-milk/60">${formatTimeAgo(reply.created_at)}</span>
                            </div>
                            <p class="text-nova-milk/80 text-sm">${reply.content}</p>
                        </div>
                    </div>
                    `).join('')}
                </div>
                ` : ''}
            </div>
        </div>
    `;
    
    return div;
}

// LOAD KOMENTAR
function loadComments() {
    if (loadingComments || !hasMoreComments) return;
    
    loadingComments = true;
    const videoId = '{{ $video["id"] }}';
    const loadingEl = document.getElementById('loadingComments');
    
    if (currentCommentPage === 1 && loadingEl) {
        loadingEl.classList.remove('hidden');
    }
    
    fetch(`/videos/${videoId}/comments?page=${currentCommentPage}`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('commentsContainer');
            
            if (currentCommentPage === 1) {
                container.innerHTML = '';
                document.getElementById('noComments').classList.add('hidden');
            }
            
            if (loadingEl) {
                loadingEl.classList.add('hidden');
            }
            
            if (data.data && data.data.length > 0) {
                data.data.forEach(comment => {
                    container.appendChild(createCommentElement(comment));
                });
                
                // Update comment count
                document.getElementById('commentCount').textContent = `(${data.total || 0})`;
                
                // Tampilkan load more jika ada
                if (data.next_page_url) {
                    document.getElementById('loadMoreComments').classList.remove('hidden');
                    hasMoreComments = true;
                    currentCommentPage++;
                } else {
                    document.getElementById('loadMoreComments').classList.add('hidden');
                    hasMoreComments = false;
                }
            } else if (currentCommentPage === 1) {
                // Tidak ada komentar
                container.innerHTML = '';
                document.getElementById('noComments').classList.remove('hidden');
                document.getElementById('loadMoreComments').classList.add('hidden');
            }
            
            loadingComments = false;
        })
        .catch(error => {
            console.error('Error loading comments:', error);
            loadingComments = false;
            if (loadingEl) loadingEl.classList.add('hidden');
        });
}

// SUBMIT COMMENT
document.getElementById('commentForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitComment');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Posting...';
    
    const formData = new FormData(this);
    
    fetch('{{ route("comments.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reset form
            document.getElementById('commentContent').value = '';
            document.getElementById('commentContent').style.height = 'auto';
            
            // Reload comments from page 1
            currentCommentPage = 1;
            hasMoreComments = true;
            loadComments();
            
            showNotification('Comment added successfully!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding comment', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});

// REPLY FUNCTIONS
function showReplyForm(commentId) {
    if (!{{ auth()->check() ? 'true' : 'false' }}) {
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    const form = document.getElementById(`replyForm-${commentId}`);
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        document.getElementById(`replyInput-${commentId}`).focus();
    }
}

function hideReplyForm(commentId) {
    document.getElementById(`replyForm-${commentId}`).classList.add('hidden');
}

function submitReply(event, commentId) {
    event.preventDefault();
    
    const input = document.getElementById(`replyInput-${commentId}`);
    const content = input.value.trim();
    
    if (!content) return;
    
    const formData = new FormData();
    formData.append('video_id', '{{ $video["id"] }}');
    formData.append('content', content);
    formData.append('parent_id', commentId);
    formData.append('_token', csrfToken);
    
    fetch('{{ route("comments.store") }}', {
        method: 'POST',
        headers: {
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            hideReplyForm(commentId);
      
            currentCommentPage = 1;
            loadComments();
            showNotification('Reply added!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding reply', 'error');
    });
}

// DELETE COMMENT
function deleteComment(commentId) {
    if (!confirm('Are you sure you want to delete this comment?')) return;
    
    fetch(`/comments/${commentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove comment from DOM
            document.querySelector(`.comment-item[data-comment-id="${commentId}"]`)?.remove();
            showNotification('Comment deleted');
            
            // Update comment count
            const countEl = document.getElementById('commentCount');
            const currentCount = parseInt(countEl.textContent.replace(/[()]/g, '')) || 0;
            countEl.textContent = `(${Math.max(0, currentCount - 1)})`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error deleting comment', 'error');
    });
}

// LIKE COMMENT (basic implementation)
function toggleLikeComment(commentId) {
    if (!{{ auth()->check() ? 'true' : 'false' }}) {
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    // Implement like logic here
    showNotification('Like functionality coming soon!', 'info');
}

// LOAD MORE COMMENTS
document.getElementById('loadMoreBtn')?.addEventListener('click', loadComments);

// INITIAL LOAD
document.addEventListener('DOMContentLoaded', function() {
    loadComments();
});
</script>