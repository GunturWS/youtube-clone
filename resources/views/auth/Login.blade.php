@extends('layout.app')
@section('content')

<div class="min-h-screen bg-gradient-to-b from-[#121212] to-[#000000] flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Animated Background Effect -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -left-40 w-80 h-80 bg-[#ff0000] rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
            <div class="absolute top-40 -right-40 w-80 h-80 bg-[#ff4400] rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-40 left-40 w-80 h-80 bg-[#ff0066] rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Main Card -->
        <div class="relative bg-[#181818]/90 backdrop-blur-xl rounded-2xl border border-[#333333]/50 shadow-2xl overflow-hidden">
            <!-- Gradient Top Border -->
            <div class="h-1 bg-gradient-to-r from-[#FF0000] via-[#FF4400] to-[#FF0066]"></div>
            
            <!-- Content -->
            <div class="p-8">
                <!-- Logo -->
                <div class="flex flex-col items-center mb-8">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#FF0000] to-[#FF4400] blur-lg opacity-50 rounded-full"></div>
                        <span class="relative text-4xl font-black tracking-tight bg-gradient-to-r from-[#FF0000] via-[#FF4400] to-[#FF0066] bg-clip-text text-transparent">
                            WowTube
                        </span>
                    </div>
                    <p class="mt-2 text-sm text-[#b3b3b3] font-medium">Music & Videos Platform</p>
                </div>

                <!-- Welcome Text -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-white mb-2">Welcome back</h1>
                    <p class="text-[#b3b3b3] text-sm">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-white font-medium hover:text-[#FF0000] transition-colors duration-200">
                            Sign up for WowTube
                        </a>
                    </p>
                </div>

                <!-- Messages -->
                @if(session('success'))
                    <div class="mb-6 p-3 bg-gradient-to-r from-green-900/20 to-emerald-900/20 border border-emerald-700/30 rounded-xl text-emerald-300 text-sm backdrop-blur-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-gradient-to-r from-red-900/20 to-pink-900/20 border border-red-700/30 rounded-xl backdrop-blur-sm">
                        <div class="flex items-center text-red-300 mb-2">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">Please check your credentials</span>
                        </div>
                        <ul class="text-sm text-red-200/80 space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="flex items-start">
                                    <span class="inline-block w-1 h-1 mt-2 mr-2 bg-red-400 rounded-full"></span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Social Login -->
                <div class="mb-6 space-y-3">
                    <button class="w-full flex items-center justify-center gap-3 p-3 bg-[#282828] hover:bg-[#333333] border border-[#404040] rounded-xl transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] group">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-white font-medium">Continue with Google</span>
                    </button>
                    
                    <button class="w-full flex items-center justify-center gap-3 p-3 bg-[#282828] hover:bg-[#333333] border border-[#404040] rounded-xl transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] group">
                        <svg class="w-5 h-5" fill="white" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        <span class="text-white font-medium">Continue with GitHub</span>
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-[#404040]"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-[#181818] text-[#b3b3b3] font-medium">Or continue with email</span>
                    </div>
                </div>

                <!-- Login Form -->
                <form class="space-y-4" action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-[#b3b3b3] mb-2">
                            Email address
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                placeholder="name@example.com"
                                required
                                class="w-full px-4 py-3 bg-[#282828] border border-[#404040] rounded-xl text-white placeholder-[#666] focus:outline-none focus:ring-2 focus:ring-[#FF0000]/50 focus:border-transparent transition-all duration-200"
                                autocomplete="email"
                            >
                            <div class="absolute right-3 top-3">
                                <svg class="w-5 h-5 text-[#666]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium text-[#b3b3b3]">
                                Password
                            </label>
                            <a href="#" class="text-sm text-[#b3b3b3] hover:text-white transition-colors duration-200">
                                Forgot password?
                            </a>
                        </div>
                        <div class="relative">
                            <input 
                                type="password" 
                                name="password" 
                                placeholder="••••••••"
                                required
                                class="w-full px-4 py-3 bg-[#282828] border border-[#404040] rounded-xl text-white placeholder-[#666] focus:outline-none focus:ring-2 focus:ring-[#FF0000]/50 focus:border-transparent transition-all duration-200"
                                autocomplete="current-password"
                            >
                            <div class="absolute right-3 top-3">
                                <svg class="w-5 h-5 text-[#666]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            id="remember"
                            class="h-4 w-4 text-[#FF0000] bg-[#282828] border-[#404040] rounded focus:ring-[#FF0000]/50 focus:ring-offset-0"
                        >
                        <label for="remember" class="ml-2 text-sm text-[#b3b3b3] cursor-pointer">
                            Remember me for 30 days
                        </label>
                    </div>

                    <button 
                        type="submit"
                        class="w-full py-3.5 bg-gradient-to-r from-[#FF0000] to-[#FF4400] text-white font-semibold rounded-xl hover:from-[#ff3333] hover:to-[#ff6633] active:scale-[0.98] transition-all duration-200 shadow-lg hover:shadow-xl hover:shadow-red-500/20"
                    >
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Sign in to account
                        </span>
                    </button>
                </form>

                <!-- Demo Account -->
                <div class="mt-6 p-3 bg-[#282828]/50 rounded-xl border border-[#404040]/50">
                    <div class="flex items-center text-[#b3b3b3] text-sm">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span>Demo account: <strong class="text-white">demo@example.com</strong> / <strong class="text-white">password</strong></span>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 pt-6 border-t border-[#333] text-center">
                    <p class="text-[#888] text-sm">
                        By signing in, you agree to our 
                        <a href="#" class="text-white hover:text-[#FF0000] transition-colors duration-200">Terms</a> 
                        and 
                        <a href="#" class="text-white hover:text-[#FF0000] transition-colors duration-200">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Back Link -->
        <div class="mt-6 text-center">
            <!-- Ganti semua '/' dengan route('youtube.index') -->
<a href="{{ route('youtube.index') }}" class="inline-flex items-center text-[#b3b3b3] hover:text-white transition-colors duration-200 group">
    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    Back to homepage
</a>
        </div>
    </div>
</div>

<style>
    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
        100% {
            transform: translate(0px, 0px) scale(1);
        }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    /* Smooth focus states */
    input:focus, button:focus {
        outline: none;
        ring-width: 2px;
    }
    
    /* Custom checkbox */
    input[type="checkbox"]:checked {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
    }
</style>

@endsection