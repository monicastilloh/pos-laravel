@extends('layouts.app')

@section('content')

<h2> Agregar cajero</h2>

<div class="card">
    <form method="POST" action="{{ route('usuarios.store') }}">
        @csrf

        <div>
            <label>Nombre</label>
            <input type="text" name="name" autocomplete="off" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" autocomplete="off" required>
        </div>

        <div>
            <label>Contraseña</label>
            <input type="password" name="password" autocomplete="new-password" required>
        </div>

        <div>
            <label>Confirmar contraseña</label>
            <input type="password" name="password_confirmation" autocomplete="new-password" required>
        </div>

        <button class="btn-primary">
            Guardar cajero
        </button>
    </form>
</div>

@endsection
