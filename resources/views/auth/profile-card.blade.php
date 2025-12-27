@props(['user'])

<div class="bg-[#181818] rounded-xl p-6">
    <div class="flex items-start gap-6 mb-8">
        <div class="relative">
            <div class="w-24 h-24 bg-gradient-to-r from-red-600 to-pink-600 rounded-full flex items-center justify-center">
                <span class="text-3xl font-bold text-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>
        </div>
        <div>
            <h2 class="text-xl font-semibold text-white mb-1">{{ $user->name }}</h2>
            <p class="text-gray-400 mb-3">{{ $user->email }}</p>
            <!-- ... rest of profile card -->
        </div>
    </div>
</div>