<nav class="fixed top-0 left-0 right-0 h-16 bg-white border-b z-50">
    <div class="h-full flex items-center">

        <!-- LEFT -->
        <div class="w-60 flex items-center gap-3 px-4">
            <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100">
                {{-- <x-heroicon-o-bars-3 class="w-6 h-6" /> --}}
            </button>

            <span class="text-xl font-bold tracking-tight select-none">
                YouTube
            </span>
        </div>

        <!-- CENTER -->
        <div class="flex-1 flex justify-center">
            <form class="flex w-full max-w-[600px]">
                <input
                    type="text"
                    placeholder="Search"
                    class="flex-1 h-10 border border-gray-300 rounded-l-full px-4 text-sm
                           focus:outline-none focus:border-blue-500"
                >

                <button
                    type="submit"
                    class="w-16 h-10 border border-l-0 border-gray-300
                           rounded-r-full bg-gray-100 hover:bg-gray-200
                           flex items-center justify-center"
                >
                    {{-- <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-600" /> --}}
                </button>
            </form>
        </div>

        <!-- RIGHT -->
        <div class="w-60 flex items-center justify-end gap-4 px-4">
            <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100">
                {{-- <x-heroicon-o-bell class="w-6 h-6 text-gray-700" /> --}}
            </button>

            <div class="w-9 h-9 rounded-full bg-gray-400 cursor-pointer"></div>
        </div>

    </div>
</nav>
