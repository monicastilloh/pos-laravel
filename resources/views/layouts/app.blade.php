<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>POS</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<header class="navbar">
    <div class="logo">🧾 POS</div>

    <nav class="menu">
        <a href="/inventario">Inventario</a>
        <a href="/ventas">Ventas</a>
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
