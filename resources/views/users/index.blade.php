@extends('layouts.app')

@section('content')

<h2>👥 Cajeros</h2>

<button class="btn-primary" onclick="toggleCreate()">
    + Agregar cajero
</button>

{{-- FORM CREAR --}}
<div id="create-form" class="card hidden mt-3">
    <form method="POST" action="{{ route('usuarios.store') }}">
        @csrf

        <input type="text" name="name" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" minlength="8" required>
        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>

        <button class="btn-primary">Guardar</button>
        <button type="button" class="btn-secondary" onclick="toggleCreate()">Cancelar</button>
    </form>
</div>

{{-- TABLA --}}
<div class="card mt-4">
<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <button class="btn-secondary" onclick="toggleEdit({{ $user->id }})">
                        Editar
                    </button>

                    <form method="POST"
                          action="{{ route('usuarios.destroy', $user) }}"
                          style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn-danger"
                                onclick="return confirm('¿Eliminar cajero?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>

            {{-- FORM EDITAR DESPLEGABLE --}}
            <tr id="edit-{{ $user->id }}" class="hidden">
                <td colspan="3">
                    <form method="POST"
                          action="{{ route('usuarios.update', $user) }}"
                          class="card">
                        @csrf
                        @method('PUT')

                        <input type="text" name="name"
                               value="{{ $user->name }}" required>

                        <input type="email" name="email"
                               value="{{ $user->email }}" required>

                        <input type="password" name="password"
                               placeholder="Nueva contraseña (opcional)"
                               minlength="8">

                        <input type="password" name="password_confirmation"
                               placeholder="Confirmar contraseña">

                        <button class="btn-primary">Guardar</button>
                        <button type="button"
                                class="btn-secondary"
                                onclick="toggleEdit({{ $user->id }})">
                            Cancelar
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>

{{-- JS --}}
<script>
function toggleEdit(id) {
    document.getElementById('edit-' + id).classList.toggle('hidden');
}

function toggleCreate() {
    document.getElementById('create-form').classList.toggle('hidden');
}
</script>

@endsection
