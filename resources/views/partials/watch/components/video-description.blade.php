<!-- Description -->
<div class="mt-6 bg-[#2e2e2e] text-[#e7d7ad] rounded-xl p-4 text-sm whitespace-pre-line">
    <div class="font-semibold mb-2">Description</div>
    {{ $video['snippet']['description'] }}
    
    <!-- Published Date -->
    <div class="mt-4 pt-4 border-t border-nova-milk/10 text-xs text-nova-milk/60">
        Published on {{ \Carbon\Carbon::parse($video['snippet']['publishedAt'])->format('F j, Y') }}
    </div>
</div>