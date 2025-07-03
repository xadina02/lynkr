<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lynkr</title>
    @vite(['resources/css/app.css', 'resources/js/login.js'])
</head>

<body class="body-div min-h-screen flex flex-col">
    <div class="login-container">
        <div class="login-card">
            <h2 class="login-title">Login to Lynkr as Admin</h2>

            @if (session('error'))
                <div class="login-error-server">
                    {{ session('error') }}
                </div>
            @endif

            <div id="login-error" class="login-error-client"></div>

            <form id="login-form" class="login-form">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" required class="form-input">
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" required class="form-input">
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-remember">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" class="remember-checkbox">
                        <span class="remember-text">Remember Me</span>
                    </label>
                </div>

                <button type="submit" class="login-button">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
