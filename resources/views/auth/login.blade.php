<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión | POS</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="login-body">

<div class="login-container">

    <div class="login-card">

        <div class="login-header">
            <h1> POS</h1>
            <p>Iniciar de sesión</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="login-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="off"
                >
            </div>

            <div class="login-group">
                <label>Contraseña</label>
                <input
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button class="login-btn">
                Entrar
            </button>
        </form>

        <div class="login-footer">
            <small>Programación web</small>
        </div>

    </div>

</div>

</body>
</html>
