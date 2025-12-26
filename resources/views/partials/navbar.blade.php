<nav class="fixed top-0 inset-x-0 h-16 bg-[#0F0F0F] border-b border-[#272727] z-50">
    <div class="h-full flex items-center text-[#F1F1F1]">

        <!-- LEFT -->
        <div class="w-60 flex items-center gap-4 px-5">
            <button
                id="sidebarToggle"
                class="w-9 h-9 grid place-items-center rounded-full
                       hover:bg-[#272727] transition"
            >
                ☰
            </button>

            <span class="text-lg font-semibold tracking-tight">
                WowTube
            </span>
        </div>

        <!-- CENTER -->
        <div class="flex-1 flex justify-center">
            <form
                action="{{ route('youtube.index') }}"
                method="GET"
                class="flex w-full max-w-[560px]"
            >
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search"
                    class="flex-1 h-9 px-4 text-sm
                           bg-[#121212] text-[#F1F1F1]
                           border border-[#303030]
                           rounded-l-full
                           placeholder:text-[#AAAAAA]
                           focus:outline-none
                           focus:border-[#FF0000]"
                >

                <button
                    type="submit"
                    class="h-9 px-5 grid place-items-center
                           bg-[#272727] hover:bg-[#303030]
                           border border-l-0 border-[#303030]
                           rounded-r-full transition"
                >
                    🔍
                </button>
            </form>
        </div>

        <!-- RIGHT -->
        <div class="w-60 flex items-center justify-end gap-3 px-5">
            <button
                class="w-9 h-9 grid place-items-center rounded-full
                       hover:bg-[#272727] transition"
            >
                🔔
            </button>

            <div
                class="w-8 h-8 rounded-full bg-[#AAAAAA]
                       hover:ring-2 hover:ring-[#FF0000]
                       transition cursor-pointer"
            ></div>
        </div>

    </div>
</nav>
