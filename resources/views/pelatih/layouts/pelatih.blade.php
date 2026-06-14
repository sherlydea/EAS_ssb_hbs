<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pelatih - SSB HBS</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-[#fff8e7]">

    {{-- NAVBAR (fixed top, full width) --}}
    @include('pelatih.partials.sidebar')

    {{-- CONTENT (pt sesuai tinggi navbar ~72px) --}}
    <main class="pt-[72px] min-h-screen">
        <div class="max-w-7xl mx-auto p-6">
            @yield('content')
        </div>
    </main>

    {{-- SCRIPTS --}}
    @stack('scripts')

</body>
</html>