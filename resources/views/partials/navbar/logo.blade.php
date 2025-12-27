<div class="w-60 flex items-center gap-4 px-5">
    <button
        id="sidebarToggle"
        class="w-9 h-9 grid place-items-center rounded-full hover:bg-[#272727] transition"
        aria-label="Toggle sidebar"
    >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
        </svg>
    </button>

    <a href="{{ route('youtube.index') }}" class="flex items-center gap-2 hover:opacity-90 transition-opacity">
        <span class="text-lg font-semibold tracking-tight text-[#FF0000]">
            WowTube
        </span>
    </a>
</div>