@extends('layouts.app')

@section('content')

<h2> Cambiar contraseña</h2>

<div class="card">

    <p>
        Por seguridad, debes cambiar tu contraseña antes de continuar.
    </p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <div>
            <label>Nueva contraseña</label>
            <input
                type="password"
                name="password"
                required
                minlength="6"
            >
        </div>

        <div>
            <label>Confirmar contraseña</label>
            <input
                type="password"
                name="password_confirmation"
                required
                minlength="6"
            >
        </div>

        <button class="btn-primary">
            Guardar contraseña
        </button>
    </form>

</div>

@endsection
