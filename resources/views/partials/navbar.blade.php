<nav class="fixed top-0 inset-x-0 h-16 bg-[#0F0F0F] border-b border-[#272727] z-50">
    <div class="h-full flex items-center text-[#F1F1F1]">
        <!-- LEFT: Logo & Toggle -->
        @include('partials.navbar.logo')
        
        <!-- CENTER: Search Bar -->
        @include('partials.navbar.search')
        
        <!-- RIGHT: User Menu or Guest Buttons -->
        <div class="w-60 flex items-center justify-end gap-3 px-5">
            @auth
                <!-- Notification Button -->
                <button class="w-9 h-9 grid place-items-center rounded-full hover:bg-[#272727] transition relative">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                    </svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                
                <!-- User Menu Component -->
                @include('partials.navbar.user-menu')
            @else
                @include('partials.auth.guest-buttons')
            @endauth
        </div>
    </div>
</nav>

<style>
    /* Dropdown animation */
    .group:hover .group-hover\:visible {
        visibility: visible;
    }
    
    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }
</style>