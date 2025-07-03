<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lynkr</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="body-div min-h-screen flex flex-col">
    <nav class="bg-blue-600 text-white p-4 flex justify-between items-center d-flex">
        <div class="text-xl font-bold">Lynkr</div>
        <div class="actions">
            <div id="auth-nav" class="hidden">
                <a href="{{ url('/countries') }}" class="nav-link mr-4"><b>Countries</b></a>
                {{-- <a href="{{ url('/brands') }}" class="nav-link mr-4"><b>Brands</b></a> --}}
                <form id="logout-form" class="inline">
                    @csrf
                    <button type="submit" class="logout-button bg-white text-blue-600 px-3 py-1 rounded">Logout</button>
                </form>
            </div>

            <div id="guest-nav" class="hidden">
                <a href="{{ url('/login') }}" class="login-button bg-white text-blue-600 px-3 py-1 rounded">Login</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow p-4">
        @yield('content')
    </main>
</body>

</html>
