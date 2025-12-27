@extends('layout.app')
@section('content')

<div class="min-h-screen bg-[#0a0a0a] flex items-center justify-center p-4 sm:p-6">
    <div class="w-full max-w-md">
        <!-- Background Decoration -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-72 h-72 bg-red-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-64 h-64 bg-red-500/3 rounded-full blur-3xl"></div>
        </div>

        <!-- Main Container -->
        <div class="relative">
            <!-- Decorative Corner Elements -->
            <div class="absolute -top-2 -left-2 w-4 h-4 border-t-2 border-l-2 border-red-500/30"></div>
            <div class="absolute -top-2 -right-2 w-4 h-4 border-t-2 border-r-2 border-red-500/30"></div>
            <div class="absolute -bottom-2 -left-2 w-4 h-4 border-b-2 border-l-2 border-red-500/30"></div>
            <div class="absolute -bottom-2 -right-2 w-4 h-4 border-b-2 border-r-2 border-red-500/30"></div>

            <!-- Content Card -->
            <div class="relative bg-black/40 backdrop-blur-sm border border-gray-800/50 rounded-xl shadow-2xl overflow-hidden">
                <!-- Header Section -->
                <div class="px-8 pt-8 pb-6 border-b border-gray-800/50">
                    <!-- Logo -->
                    <div class="flex items-center justify-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">W</span>
                        </div>
                        <span class="text-2xl font-bold text-white tracking-tight">WowTube</span>
                    </div>

                    <!-- Welcome Text -->
                    <div class="text-center">
                        <h1 class="text-xl font-semibold text-white mb-1">Join WowTube</h1>
                        <p class="text-gray-400 text-sm">Create your account to start watching</p>
                    </div>

                    <!-- Login Link -->
                    <div class="mt-4 text-center">
                        <p class="text-gray-500 text-sm">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-red-500 hover:text-red-400 font-medium transition-colors">
                                Sign in
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Messages -->
                <div class="px-8 pt-6">
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-900/20 border border-green-700/30 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-green-300 text-sm">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-3 bg-red-900/10 border border-red-700/20 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-red-300 font-medium text-sm">Please check the following</span>
                            </div>
                            <ul class="text-red-300/80 text-sm space-y-1 pl-6">
                                @foreach($errors->all() as $error)
                                    <li class="list-disc">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Registration Form -->
                <div class="px-8 pb-8">
                    <form action="{{ route('register') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- Name Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Full name
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="name" 
                                    value="{{ old('name') }}"
                                    placeholder="Enter your full name"
                                    required
                                    class="w-full px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 
                                           focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/30 transition-colors"
                                >
                                <div class="absolute right-3 top-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Email address
                            </label>
                            <div class="relative">
                                <input 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}"
                                    placeholder="you@example.com"
                                    required
                                    class="w-full px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 
                                           focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/30 transition-colors"
                                >
                                <div class="absolute right-3 top-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password" 
                                    placeholder="Create a password"
                                    required
                                    class="w-full px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 
                                           focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/30 transition-colors"
                                >
                                <div class="absolute right-3 top-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters</p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Confirm password
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password_confirmation" 
                                    placeholder="Confirm your password"
                                    required
                                    class="w-full px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-white placeholder-gray-500 
                                           focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500/30 transition-colors"
                                >
                                <div class="absolute right-3 top-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Terms Checkbox -->
                        <div class="pt-2">
                            <div class="flex items-start space-x-3 p-3 bg-gray-900/30 rounded-lg border border-gray-700/30">
                                <input 
                                    type="checkbox" 
                                    name="terms" 
                                    id="terms"
                                    required
                                    class="mt-1 h-4 w-4 rounded border-gray-600 bg-gray-800 text-red-500 focus:ring-red-500/30 focus:ring-offset-0"
                                >
                                <label for="terms" class="text-sm text-gray-300">
                                    I agree to the 
                                    <a href="#" class="text-red-400 hover:text-red-300 font-medium">Terms of Service</a> 
                                    and 
                                    <a href="#" class="text-red-400 hover:text-red-300 font-medium">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button 
                                type="submit"
                                class="w-full py-3.5 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg 
                                       hover:from-red-500 hover:to-red-600 active:scale-[0.98] transition-all duration-200 
                                       border border-red-700/50 shadow-lg"
                            >
                                Create account
                            </button>
                        </div>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-800"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-3 bg-black/40 text-gray-500">Or continue with</span>
                        </div>
                    </div>

                    <!-- Social Login -->
                    <div class="grid grid-cols-2 gap-3">
                        <button class="flex items-center justify-center gap-2 px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg 
                                      hover:bg-gray-800/50 transition-colors group">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="text-gray-300 text-sm font-medium">Google</span>
                        </button>
                        
                        <button class="flex items-center justify-center gap-2 px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg 
                                      hover:bg-gray-800/50 transition-colors group">
                            <svg class="w-5 h-5" fill="white" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                            <span class="text-gray-300 text-sm font-medium">GitHub</span>
                        </button>
                    </div>

                    <!-- Footer Note -->
                    <div class="mt-6 pt-5 border-t border-gray-800/50">
                        <p class="text-center text-gray-500 text-sm">
                            By creating an account, you agree to our terms and acknowledge our privacy policy.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Back Link -->
            <div class="mt-4 text-center">
                <a href="/" class="inline-flex items-center text-gray-500 hover:text-gray-300 text-sm transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Return to homepage
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom focus styles */
    input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.1);
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #1a1a1a;
    }

    ::-webkit-scrollbar-thumb {
        background: #444;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Checkbox styling */
    input[type="checkbox"] {
        border-radius: 3px;
    }

    input[type="checkbox"]:checked {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
        background-size: 85%;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>

@endsection