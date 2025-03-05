<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="text-white font-bold">
            Chat Room
        </a>
        <div>
            @if (Route::has('login'))
                    @auth
                        <span class="text-white mr-4">Welcome, {{ auth()->user()->name }}!</span>
                        <a href="{{ route('logout') }}" class="text-white">Logout</a>
                    @else
                        <a href="{{ route('login') }}" class="text-white mr-4">Login</a>

                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-white">Register</a>
                        @endif
                    @endauth
            @endif
        </div>
    </div>
</nav>
