<!-- COMMENT FORM -->
@auth
    <div class="mb-6 bg-[#2e2e2e] rounded-xl p-4">
        <form id="commentForm" class="space-y-3">
            @csrf
            <input type="hidden" name="video_id" value="{{ $video['id'] }}">
            
            <div class="flex items-start gap-3">
                <!-- User Avatar -->
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold flex-shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                
                <!-- Comment Input -->
                <div class="flex-1">
                    <textarea 
                        name="content" 
                        id="commentContent"
                        rows="2"
                        class="w-full bg-[#1a1a1a] border border-nova-milk/20 rounded-lg p-3 text-nova-milk placeholder-nova-milk/50 focus:outline-none focus:ring-2 focus:ring-nova-yellow focus:border-transparent resize-none"
                        placeholder="Add a public comment..."
                        oninput="autoResize(this)"
                    ></textarea>
                    
                    <div class="flex justify-end mt-2">
                        <button
                            type="button"
                            onclick="document.getElementById('commentForm').reset();"
                            class="px-4 py-2 mr-2 bg-transparent text-nova-milk/70 hover:text-nova-milk transition"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            id="submitComment"
                            class="px-4 py-2 bg-nova-yellow text-nova-dark font-semibold rounded-lg hover:bg-yellow-600 transition disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Comment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@else
    <div class="bg-[#2e2e2e] p-4 rounded-lg text-center mb-6">
        <p class="text-nova-milk/70 mb-2">
            <i class="fas fa-lock mr-2"></i>Login to comment on this video
        </p>
        <a href="{{ route('login') }}" class="text-nova-yellow hover:underline font-semibold">
            <i class="fas fa-sign-in-alt mr-2"></i>Sign in
        </a>
    </div>
@endauth