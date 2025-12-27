@extends('layout.app')
@section('content')

<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white mb-2">Your Profile</h1>
            <p class="text-gray-400">Manage your account settings and preferences</p>
        </div>

        <!-- Profile Card -->
        <div class="bg-[#181818] rounded-xl p-6 mb-6">
            <!-- Avatar & Basic Info -->
            <div class="flex items-start gap-6 mb-8">
                <div class="relative">
                    <div class="w-24 h-24 bg-gradient-to-r from-red-600 to-pink-600 rounded-full flex items-center justify-center">
                        <span class="text-3xl font-bold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-gray-800 rounded-full border-4 border-[#181818] flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-white mb-1">{{ auth()->user()->name }}</h2>
                    <p class="text-gray-400 mb-3">{{ auth()->user()->email }}</p>
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2 text-gray-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <span>Joined {{ auth()->user()->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                            </svg>
                            <span>Premium User</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-[#222] rounded-lg p-4">
                    <div class="text-gray-400 text-sm mb-1">Watched Videos</div>
                    <div class="text-2xl font-bold text-white">0</div>
                    <div class="text-xs text-gray-500">This month</div>
                </div>
                <div class="bg-[#222] rounded-lg p-4">
                    <div class="text-gray-400 text-sm mb-1">Liked Videos</div>
                    <div class="text-2xl font-bold text-white">0</div>
                    <div class="text-xs text-gray-500">Total favorites</div>
                </div>
                <div class="bg-[#222] rounded-lg p-4">
                    <div class="text-gray-400 text-sm mb-1">Watch Time</div>
                    <div class="text-2xl font-bold text-white">0h</div>
                    <div class="text-xs text-gray-500">Total hours</div>
                </div>
            </div>

            <!-- Edit Profile Form -->
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Account Information</h3>
                    
                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                               class="w-full px-4 py-3 bg-[#222] border border-gray-700 rounded-lg text-white 
                                      focus:outline-none focus:border-red-500 transition-colors">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                               class="w-full px-4 py-3 bg-[#222] border border-gray-700 rounded-lg text-white 
                                      focus:outline-none focus:border-red-500 transition-colors">
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Change -->
                    <div class="pt-4 border-t border-gray-700">
                        <h4 class="text-lg font-semibold text-white mb-4">Change Password</h4>
                        
                        <!-- Current Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Current Password</label>
                            <input type="password" name="current_password" 
                                   class="w-full px-4 py-3 bg-[#222] border border-gray-700 rounded-lg text-white 
                                          focus:outline-none focus:border-red-500 transition-colors"
                                   placeholder="Enter current password">
                            @error('current_password')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">New Password</label>
                            <input type="password" name="new_password" 
                                   class="w-full px-4 py-3 bg-[#222] border border-gray-700 rounded-lg text-white 
                                          focus:outline-none focus:border-red-500 transition-colors"
                                   placeholder="Enter new password">
                            @error('new_password')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" 
                                   class="w-full px-4 py-3 bg-[#222] border border-gray-700 rounded-lg text-white 
                                          focus:outline-none focus:border-red-500 transition-colors"
                                   placeholder="Confirm new password">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-700">
                        <button type="submit" 
                                class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 
                                       transition-colors">
                            Save Changes
                        </button>
                        
                        <a href="{{ route('youtube.index') }}" 
                           class="px-4 py-2 text-gray-400 hover:text-white transition-colors">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="bg-[#181818] rounded-xl p-6 border border-red-900/30">
            <h3 class="text-lg font-semibold text-white mb-2">Danger Zone</h3>
            <p class="text-gray-400 text-sm mb-4">Once you delete your account, there is no going back. Please be certain.</p>
            
            <form action="{{ route('profile.destroy') }}" method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-900/20 text-red-400 border border-red-700/30 rounded-lg 
                               hover:bg-red-900/30 hover:text-red-300 transition-colors">
                    Delete Account
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div id="successToast" class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
</div>
<script>
    setTimeout(() => document.getElementById('successToast')?.remove(), 3000);
</script>
@endif

@endsection