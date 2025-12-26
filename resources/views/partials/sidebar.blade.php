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

        <!-- BERANDA -->
        <a href="{{ route('youtube.index') }}"
           class="flex items-center gap-4 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('youtube.index')
                ? 'bg-[#272727] font-medium'
                : 'hover:bg-[#272727]' }}"
        >
            <img src="{{ asset('icon/Home_Fill.svg') }}" class="w-7 h-7">
            <span>Beranda</span>
        </a>

        <!-- TRENDING -->
        <a href="{{ route('youtube.trending') }}"
           class="flex items-center gap-4 px-3 py-2 rounded-xl transition
           {{ request()->routeIs('youtube.trending')
                ? 'bg-[#272727] font-medium'
                : 'hover:bg-[#272727]' }}"
        >
            <img src="{{ asset('icon/Trending_Fill.svg') }}" class="w-7 h-7">
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

