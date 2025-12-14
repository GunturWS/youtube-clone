<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>YouTube Clone</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900">

    @include('partials.navbar')
    @include('partials.sidebar')

    <main class="pt-16 pl-60">
        @yield('content')
    </main>

</body>
</html>
