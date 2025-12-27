@php
$showLimit = 4;
@endphp

@php
$subscriptions = [
    ['name' => 'Fireship', 'icon' => 'icon/Subscriptions_Fill.svg'],
    ['name' => 'Web Programming', 'icon' => 'icon/Subscriptions_Fill.svg'],
    ['name' => 'Laravel Daily', 'icon' => 'icon/Subscriptions_Fill.svg'],
    ['name' => 'Flutter Dev', 'icon' => 'icon/Subscriptions_Fill.svg'],
    ['name' => 'AI Research', 'icon' => 'icon/Subscriptions_Fill.svg'],
    ['name' => 'Design UI UX', 'icon' => 'icon/Subscriptions_Fill.svg'],
];
@endphp

<aside
    id="sidebar"
    class="fixed top-16 left-0 w-60 h-[calc(100vh-4rem)]
           bg-[#0F0F0F]
           border-r border-[#272727]
           px-3 py-4 text-[#F1F1F1]
           transition-transform duration-300"
>

    <nav class="space-y-1 text-sm">

        <!-- Home link -->
<a href="{{ route('youtube.index') }}" 
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-[#272727] transition 
          {{ request()->routeIs('youtube.index') ? 'bg-[#272727]' : '' }}">
    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
    </svg>
    <span>Home</span>
</a>

<!-- Trending link -->
<a href="{{ route('youtube.trending') }}" 
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-[#272727] transition 
          {{ request()->routeIs('youtube.trending') ? 'bg-[#272727]' : '' }}">
    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
    </svg>
    <span>Trending</span>
</a>

        <!-- SUBSCRIPTIONS -->
        <a href="#"
           class="flex items-center gap-4 px-3 py-2 rounded-xl hover:bg-[#272727] transition">
            <img src="{{ asset('icon/Subscriptions_Fill.svg') }}" class="w-7 h-7">
            <span>Subscriptions</span>
        </a>

        <!-- DIVIDER -->
        <div class="my-3 border-t border-[#272727]"></div>

        <p class="px-3 mt-4 text-sm font-semibold text-[#AAAAAA]">
    Subscriptions
</p>

<div id="subsWrapper"
     class="mt-1 space-y-1 max-h-[220px] overflow-hidden transition-all duration-300">

    @foreach ($subscriptions as $i => $sub)
        <a href="#"
           class="flex items-center gap-4 px-3 py-2 rounded-xl
                  hover:bg-[#272727] transition
                  {{ $i >= 4 ? 'hidden extra-sub' : '' }}">
            <img src="{{ asset($sub['icon']) }}" class="w-7 h-7">
            <span class="truncate">{{ $sub['name'] }}</span>
        </a>
    @endforeach
</div>

{{-- SHOW MORE --}}
@if(count($subscriptions) > 4)
<button
    id="showMoreSubs"
    class="w-full mt-1 px-3 py-2 text-left text-sm
           text-[#AAAAAA] hover:bg-[#272727] rounded-xl transition">
    Show more
</button>
@endif

<!-- DIVIDER -->
        <div class="my-3 border-t border-[#272727]"></div>
        <p class="px-3 mt-4 text-base font-semibold text-[#AAAAAA]">Your Account</p>

@auth
<!-- Your Profile Section -->

<a href="{{ route('profile.index') }}"  
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-[#272727] transition 
          {{ request()->routeIs('youtube.trending') ? 'bg-[#272727]' : '' }}">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
        </svg>
    <span>Your Profile</span>
</a>
 <form method="POST" action="{{ route('logout') }}" 
      onsubmit="return confirm('Are you sure you want to logout?')"
      class="w-full">
    @csrf
    <button type="submit" 
            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-[#272727] text-red-400 hover:text-red-300 transition-colors">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
        </svg>
        <span>Logout</span>
    </button>
</form>
@endauth
    </nav>
</aside>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('showMoreSubs');
    const wrapper = document.getElementById('subsWrapper');

    if (!btn || !wrapper) return;

    let expanded = false;

    btn.addEventListener('click', () => {
        expanded = !expanded;

        document.querySelectorAll('.extra-sub').forEach(el => {
            el.classList.toggle('hidden', !expanded);
        });

        wrapper.classList.toggle('overflow-y-auto', expanded);
        wrapper.classList.toggle('max-h-[220px]', expanded);

        btn.textContent = expanded ? 'Show less' : 'Show more';
    });
});
</script>

