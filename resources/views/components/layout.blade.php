<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <meta name="author" content="msandypr">
    <meta name="description" content="task-manager">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: karla;
        }

        .cta-btn {
            color: #3d68ff;
        }

        .upgrade-btn {
            background: #1947ee;
        }

        .upgrade-btn:hover {
            background: #0038fd;
        }

        .nav-item:hover {
            background: #1947ee;
        }

        .account-link:hover {
            background: #3d68ff;
        }
    </style>
</head>

<body class="bg-gray-100 font-family-karla w-auto flex flex-col" x-data="{ isOpen: false }">

    <!-- Navbar -->
    <header class="w-full bg-white py-4 px-6 flex items-center justify-between">
        <div>
            <a href="{{ route('task.index') }}" class="text-blue-600 text-3xl font-semibold uppercase">Task Manager</a>
        </div>
        <nav class="hidden md:flex items-center space-x-4">
            @auth
                @if (Auth::user()->admin)
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center text-blue-600 hover:text-gray-700">
                        <i class="fas fa-newspaper mr-2"></i>
                        Admin Dashboard
                    </a>
                @endif
                <a href="/user/{{ auth()->id() }}/dashboard" class="flex items-center text-blue-600 hover:text-gray-700">
                    <i class="fas fa-user mr-2"></i>
                    {{ ucwords(auth()->user()->name) }}'s Dashboard
                </a>
            @endauth
            <a href="{{ route('task.index') }}" class="flex items-center text-blue-600 hover:text-gray-700">
                <i class="fas fa-clipboard mr-2"></i>
                Tasks
            </a>
            @auth
                <div x-data="{ isDropdownOpen: false }" class="relative">
                    <button @click="isDropdownOpen = !isDropdownOpen" class="relative z-10 w-auto h-10 font-bold">
                        {{ ucwords(auth()->user()->name) }}
                    </button>
                    <button x-show="isDropdownOpen" @click="isDropdownOpen = false"
                        class="h-full w-full fixed inset-0 cursor-default"></button>
                    <div x-show="isDropdownOpen" class="absolute right-0 w-48 bg-white rounded-lg shadow-lg py-2 mt-2">
                        {{-- <a href="/user/{{ auth()->id() }}/dashboard"
                            class="block px-4 py-2 account-link hover:text-white">Account</a> --}}
                        <a href="/profile" class="block px-4 py-2 account-link hover:text-white">Profile</a>
                        <form action="/logout" method="post" class="block px-4 py-2 account-link hover:text-white">
                            @csrf
                            <button>Logout</button>
                        </form>
                    </div>
                </div>
            @endauth
            @guest
                <div>
                    <a href="/register"
                        class="px-4 py-2 account-link rounded hover:bg-blue-600 hover:text-white">Register</a>
                    <a href="/login" class="px-4 py-2 account-link rounded hover:bg-blue-600 hover:text-white">Login</a>

                </div>
            @endguest
        </nav>
        <div class="md:hidden flex items-center">
            <button @click="isOpen = !isOpen" class="text-blue-600 focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <div x-show="isOpen" @click.away="isOpen = false" class="md:hidden">
        <nav class="px-2 pt-2 pb-4 space-y-1 bg-white">
            @auth
                @if (Auth::user()->admin)
                    <a href="{{ route('admin.dashboard') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:text-gray-700 hover:bg-gray-50">
                        Admin Dashboard
                    </a>
                @endif
                <a href="/user/{{ auth()->id() }}/dashboard"
                    class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:text-gray-700 hover:bg-gray-50">
                    {{ ucwords(auth()->user()->name) }}'s Dashboard
                </a>
            @endauth
            <a href="{{ route('task.index') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:text-gray-700 hover:bg-gray-50">
                Tasks
            </a>
            @auth
                {{-- <a href="/user/{{ auth()->id() }}/dashboard"
                    class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:text-gray-700 hover:bg-gray-50">Account</a> --}}
                <a href="/profile"
                    class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:text-gray-700 hover:bg-gray-50">Profile</a>
                <form action="/logout" method="post"
                    class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:text-gray-700 hover:bg-gray-50">
                    @csrf
                    <button>Logout</button>
                </form>
            @endauth
            @guest
                <a href="/register"
                    class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:text-gray-700 hover:bg-gray-50">Register</a>
                <a href="/login"
                    class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:text-gray-700 hover:bg-gray-50">Login</a>
            @endguest
        </nav>
    </div>

    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white py-2 px-4 w-1/4 rounded-xl text-sm">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Main Content -->
    <div class="w-full overflow-x-hidden border-t flex flex-col">
        <main class="w-auto flex-grow p-6">
            {{ $slot }}
        </main>

        <footer class="w-full bg-white text-right p-4">
            Built by <a target="_blank" href="#" class="underline">MSANDYPR</a>.
        </footer>
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>

</body>

</html>
