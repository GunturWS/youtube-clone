<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PRONTUB</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#0F0F0F] text-white">

    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    {{-- MAIN CONTENT --}}
    <main
        id="mainContent"
        class="pt-16 ml-60 transition-all duration-300"
    >
        @yield('content')
    </main>

    {{-- GLOBAL SIDEBAR SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            const main = document.getElementById('mainContent');

            if (!sidebar || !toggle || !main) return;

            let isOpen = true;

            toggle.addEventListener('click', () => {
                isOpen = !isOpen;

                if (isOpen) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');

                    main.classList.add('ml-60');
                    main.classList.remove('ml-0');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');

                    main.classList.remove('ml-60');
                    main.classList.add('ml-0');
                }
            });
        });
    </script>

</body>
</html>
