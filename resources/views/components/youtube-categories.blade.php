@php
$categories = [
    'All'            => null,
    'Trending'       => 'trending',
    'Music'          => 'music',
    'Gaming'         => 'gaming',
    'Live'           => 'live',
    'Podcast'        => 'podcast',
    'News'           => 'news indonesia',
    'Sports'         => 'sports',
    'Education'      => 'education',
    'Technology'     => 'technology',
    'Programming'    => 'programming',
    'Web Development'=> 'web development',
    'Mobile Dev'     => 'flutter android ios',
    'AI'             => 'artificial intelligence',
    'Machine Learning'=> 'machine learning',
    'UI UX'          => 'ui ux design',
    'Design'         => 'graphic design',
    'Photography'    => 'photography',
    'Film'           => 'film making',
    'Animation'      => 'animation',
    'Comedy'         => 'comedy',
    'Entertainment'  => 'entertainment',
    'Vlog'           => 'daily vlog',
    'Travel'         => 'travel vlog',
    'Food'           => 'food vlog',
    'Cooking'        => 'cooking',
    'ASMR'           => 'asmr',
    'Motivation'     => 'motivation',
    'Finance'        => 'finance',
    'Crypto'         => 'crypto',
    'Business'       => 'business',
    'Startup'        => 'startup',
    'Review'         => 'review',
    'Unboxing'       => 'unboxing',
];
$current = request('q');
@endphp

<div class="sticky top-16 z-40 bg-[#0F0F0F] backdrop-blur">
    <div
        class="flex gap-2 overflow-x-auto no-scrollbar
               px-6 py-3
               scroll-smooth
               whitespace-nowrap"
    >
        @foreach ($categories as $label => $value)
            <a
                href="{{ route('youtube.index', $value ? ['q' => $value] : []) }}"
                class="px-4 py-1.5 rounded-full text-sm
                       transition
                       {{ $current === $value || (!$current && !$value)
                            ? 'bg-white text-[#272727] font-medium'
                            : 'bg-[#272727] text-white hover:bg-white/20' }}"
            >
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>

