<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>POS</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<header class="navbar">
    <div class="logo"> POS</div>

    <nav class="menu">
        @if(auth()->user()->role === 'owner')
            <a href="{{ route('dashboard.owner') }}">Dashboard</a>
            <a href="{{ route('inventario') }}">Inventario</a>
            <a href="{{ route('ventas.index') }}">Ventas</a>
            <a href="{{ route('usuarios.index') }}">Cajeros</a>
        @else
            <a href="{{ route('ventas.create') }}">Ventas</a>
        @endif
    </nav>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="logout">Salir</button>
    </form>
</header>

<main class="container">
    @yield('content')
</main>

</body>
</html>
