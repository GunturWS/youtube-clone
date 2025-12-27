<div class="flex-1 flex justify-center">
    <form action="{{ route('youtube.index') }}" method="GET" class="flex w-full max-w-[560px]">
        <input
            type="text"
            name="q"
            value="{{ request('q', '') }}"
            placeholder="Search videos..."
            class="flex-1 h-9 px-4 text-sm bg-[#121212] text-[#F1F1F1] border border-[#303030] rounded-l-full placeholder:text-[#AAAAAA] focus:outline-none focus:border-[#FF0000] transition-colors"
            aria-label="Search videos"
        >

        <button
            type="submit"
            class="h-9 px-5 grid place-items-center bg-[#272727] hover:bg-[#303030] border border-l-0 border-[#303030] rounded-r-full transition-colors"
            aria-label="Search"
        >
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
            </svg>
        </button>
    </form>
</div>