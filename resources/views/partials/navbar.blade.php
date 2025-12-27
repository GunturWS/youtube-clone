<nav class="fixed top-0 inset-x-0 h-16 bg-[#0F0F0F] border-b border-[#272727] z-50">
    <div class="h-full flex items-center text-[#F1F1F1]">

        <!-- LEFT -->
        <div class="w-60 flex items-center gap-4 px-5">
            <button
                id="sidebarToggle"
                class="w-9 h-9 grid place-items-center rounded-full
                       hover:bg-[#272727] transition"
            >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                </svg>
            </button>

            <!-- PAKAI URL ABSOLUTE -->
            <a href="/" class="flex items-center gap-2">
                <span class="text-lg font-semibold tracking-tight text-[#FF0000]">
                    PRONTUB
                </span>
            </a>
        </div>

        <!-- CENTER -->
        <div class="flex-1 flex justify-center">
            <!-- PAKAI URL ABSOLUTE -->
            <form
                action="/"
                method="GET"
                class="flex w-full max-w-[560px]"
            >
                <input
                    type="text"
                    name="q"
                    value="{{ request('q', '') }}"
                    placeholder="Search videos..."
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
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </form>
        </div>

        <!-- RIGHT -->
        <div class="w-60 flex items-center justify-end gap-3 px-5">
            @auth
                <!-- User Menu for Logged In Users -->
                <button
                    class="w-9 h-9 grid place-items-center rounded-full
                           hover:bg-[#272727] transition relative"
                    id="notificationBtn"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                    </svg>
                </button>

                <!-- User Avatar with Dropdown -->
                <div class="relative">
                    <button
                        id="userMenuBtn"
                        class="flex items-center gap-2 p-1 rounded-full hover:bg-[#272727] transition"
                    >
                        <div class="w-8 h-8 rounded-full bg-[#FF0000] flex items-center justify-center">
                            <span class="text-sm font-medium text-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="userDropdown" 
                         class="hidden absolute right-0 mt-2 w-48 bg-[#0F0F0F] border border-[#272727] rounded-lg shadow-lg z-50">
                        <div class="px-4 py-3 border-b border-[#272727]">
                            <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-[#AAAAAA]">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <div class="py-1">
                            <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-[#272727] transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                <span>Your Channel</span>
                            </a>
                            
                            <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-[#272727] transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                </svg>
                                <span>Watch History</span>
                            </a>
                        </div>
                        
                        <div class="border-t border-[#272727] py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center gap-3 px-4 py-2 text-sm hover:bg-[#272727] text-[#FF0000] transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
            @else
                <!-- Buttons for Guest Users -->
                <!-- PAKAI ROUTE UNTUK LOGIN/REGISTER karena sudah didefinisikan -->
                <a href="{{ route('login') }}"
                   class="px-4 py-1.5 text-sm text-[#F1F1F1] hover:text-white transition">
                    Sign in
                </a>
                
                <a href="{{ route('register') }}"
                   class="px-4 py-1.5 text-sm bg-[#FF0000] text-white rounded-full 
                          hover:bg-[#CC0000] transition">
                    Sign up
                </a>
            @endauth
        </div>

    </div>
</nav>