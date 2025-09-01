<x-layout>
    {{-- <h1 class="text-2xl font-bold">Welcome to Laravel</h1>
    <p class="mt-4">This is your home page.</p>

    @auth
        <p class="mt-4">Hello, {{ auth()->user()->name }}!</p>

        @if (auth()->user()->role === 'admin')
            <p class="mt-4">You are logged in as an <strong>admin</strong>.</p>
        @else
            <p class="mt-4">You are logged in as a <strong>user</strong>.</p>
        @endif
    @else
        <p class="mt-4">
            You are not logged in.
            Please
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a>
            or
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">register</a>.
        </p>
    @endauth

    @can('admin')
    @endcan --}}
    <div class="grid grid-cols-2 gap-4 mt-8">
        <div class="bg-primary-400 rounded-lg shadow-md">
            <h1>Welcome to the Home</h1>
        </div>
        <div class="bg-red-100 rounded-lg shadow-md">
            <img src="#" alt="#">
        </div>
    </div>
</x-layout>
