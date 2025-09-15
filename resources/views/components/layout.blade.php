<!DOCTYPE html>
{{-- 
    1. Logika tema (x-data, x-init, :class) dipindahkan ke <html>
       agar berlaku global di seluruh halaman.
--}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ isDark: false }" x-init="isDark = localStorage.getItem('theme') === 'dark' ||
    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
document.documentElement.classList.toggle('dark', isDark);
$watch('isDark', val => {
    localStorage.setItem('theme', val ? 'dark' : 'light');
    document.documentElement.classList.toggle('dark', val);
})"
    :class="{ 'dark': isDark }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- 
        2. AlpineJS sebaiknya di-bundle melalui Vite, bukan CDN.
           Hapus script CDN jika Anda mengikuti langkah di penjelasan.
    --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="" x-cloak>

    @unless (request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('user.test.show'))
       
        <x-navigation />
    @endunless

    <main>
        {{ $slot }}
    </main>

</body>

</html>
