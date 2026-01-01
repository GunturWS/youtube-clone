<!-- COMMENTS LIST -->
<div id="commentsContainer" class="space-y-4">
    <!-- Comments will be loaded here via AJAX -->
    <div class="text-center py-8" id="loadingComments">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-nova-yellow mx-auto"></div>
        <p class="mt-2 text-nova-milk/60">Loading comments...</p>
    </div>
</div>

<!-- LOAD MORE BUTTON -->
<div id="loadMoreComments" class="text-center mt-6 hidden">
    <button 
        id="loadMoreBtn"
        class="px-4 py-2 bg-[#2e2e2e] text-nova-milk rounded-lg hover:bg-[#3a3a3a] transition flex items-center gap-2 mx-auto"
    >
        <i class="fas fa-sync-alt"></i>
        Load More Comments
    </button>
</div>

<!-- NO COMMENTS -->
<div id="noComments" class="hidden text-center py-8">
    <i class="fas fa-comment-slash text-4xl text-nova-milk/30 mb-3"></i>
    <p class="text-nova-milk/70">No comments yet. Be the first to comment!</p>
</div>