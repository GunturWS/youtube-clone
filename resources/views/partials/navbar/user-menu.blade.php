@php
    $user = auth()->user();
    $userInitial = strtoupper(substr($user->name, 0, 1));
@endphp

<div class="relative group" x-data="{ open: false }" @click.outside="open = false">
    <!-- Trigger Button -->
    <button 
        @click="open = !open"
        class="flex items-center gap-2 p-1 rounded-full hover:bg-[#272727] transition-colors focus:outline-none focus:ring-2 focus:ring-red-500/30"
        aria-label="User menu"
        aria-expanded="false"
        :aria-expanded="open"
    >
        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-red-600 to-pink-600 flex items-center justify-center ring-2 ring-transparent group-hover:ring-red-500/30 transition-all">
            <span class="text-sm font-medium text-white">{{ $userInitial }}</span>
        </div>
        <span class="text-sm hidden md:inline truncate max-w-[100px]">{{ $user->name }}</span>
        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-56 bg-[#0F0F0F] border border-[#272727] rounded-lg shadow-xl z-50 overflow-hidden"
        style="display: none;"
    >
        <!-- User Info -->
        <div class="px-4 py-3 border-b border-[#272727] bg-gradient-to-r from-[#1a1a1a] to-[#0F0F0F]">
            <p class="text-sm font-medium text-white truncate">{{ $user->name }}</p>
            <p class="text-xs text-[#AAAAAA] truncate mt-0.5">{{ $user->email }}</p>
            <p class="text-xs text-gray-500 mt-1">Member since {{ $user->created_at->format('M Y') }}</p>
        </div>
        
        <!-- Menu Items -->
        <div class="py-1">
            <a 
                href="{{ route('profile.index') }}" 
                class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-[#272727] transition-colors group/menu"
            >
                <div class="w-5 h-5 flex items-center justify-center">
                    <svg class="w-4 h-4 text-gray-400 group-hover/menu:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-gray-300 group-hover/menu:text-white transition-colors">Your Profile</span>
            </a>
            
            <a 
                href="#" 
                class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-[#272727] transition-colors group/menu"
            >
                <div class="w-5 h-5 flex items-center justify-center">
                    <svg class="w-4 h-4 text-gray-400 group-hover/menu:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-gray-300 group-hover/menu:text-white transition-colors">Settings</span>
            </a>
            
            <a 
                href="#" 
                class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-[#272727] transition-colors group/menu"
            >
                <div class="w-5 h-5 flex items-center justify-center">
                    <svg class="w-4 h-4 text-gray-400 group-hover/menu:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                    </svg>
                </div>
                <span class="text-gray-300 group-hover/menu:text-white transition-colors">Watch History</span>
            </a>
            
            <a 
                href="#" 
                class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-[#272727] transition-colors group/menu"
            >
                <div class="w-5 h-5 flex items-center justify-center">
                    <svg class="w-4 h-4 text-gray-400 group-hover/menu:text-white transition-colors" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-gray-300 group-hover/menu:text-white transition-colors">Subscriptions</span>
            </a>
        </div>
        
        <!-- Logout -->
        <div class="border-t border-[#272727] py-1 bg-gradient-to-r from-[#1a1a1a] to-[#0F0F0F]">
            <form 
                method="POST" 
                action="{{ route('logout') }}" 
                x-data="{ submitting: false }"
                @submit="submitting = true"
            >
                @csrf
                <button 
                    type="submit" 
                    :disabled="submitting"
                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-red-900/20 text-red-400 hover:text-red-300 transition-colors group/logout disabled:opacity-50"
                >
                    <div class="w-5 h-5 flex items-center justify-center">
                        <svg class="w-4 h-4 group-hover/logout:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="font-medium">
                        <template x-if="!submitting">Logout</template>
                        <template x-if="submitting">Logging out...</template>
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- AlpineJS for dropdown -->
<script src="//unpkg.com/alpinejs" defer></script>