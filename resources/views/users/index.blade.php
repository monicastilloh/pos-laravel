@extends('layouts.app')

@section('content')

<h2> Cajeros</h2>

<button class="btn-primary" onclick="toggleForm()">
    Agregar cajero
</button>

<div id="form-cajero" class="card hidden mt-3">

    <h3>Nuevo cajero</h3>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <form method="POST" action="{{ route('usuarios.store') }}">
        @csrf

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="name" required autocomplete="off">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required autocomplete="off">
        </div>

       <div class="form-group">
    <label>Contraseña</label>
    <input
        type="password"
        name="password"
        required
        minlength="8"
        autocomplete="new-password"
    >
    <small>Mínimo 8 caracteres</small>
    </div>


        <div class="form-group">
    <label>Confirmar contraseña</label>
    <input
        type="password"
        name="password_confirmation"
        required
        minlength="8"
        autocomplete="new-password"
    >
</div>


        <div class="form-actions">
            <button type="submit" class="btn-primary">
    Guardar cajero
</button>

            <button type="button" class="btn-secondary" onclick="toggleForm()">
                Cancelar
            </button>
        </div>
    </form>
</div>

<div class="card mt-4">
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">
                        No hay cajeros registrados
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- JS simple --}}
<script>
function toggleForm() {
    const form = document.getElementById('form-cajero');
    form.classList.toggle('hidden');
}
</script>

@endsection
