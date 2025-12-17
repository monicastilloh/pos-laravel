@extends('layouts.app')

@section('content')

<h2>📦 Inventario</h2>

<div class="card">
    <h3>Agregar producto</h3>

    <form method="POST" action="/inventario" class="form-grid">
        @csrf

        <div>
            <label>Nombre</label>
            <input type="text" name="name" placeholder="Ej. Pan dulce" required>
        </div>

        <div>
            <label>Stock</label>
            <input type="number" name="stock" placeholder="Ej. 50" required>
        </div>

        <div>
            <label>Precio</label>
            <input type="number" step="0.01" name="price" placeholder="Ej. 10.00" required>
        </div>

        <button type="submit" class="btn-primary">Guardar</button>
    </form>
</div>

<div class="card">
    <h3>Productos registrados</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ $p->stock }}</td>
                <td>${{ number_format($p->price, 2) }}</td>
                <td>
                    <button type="button" class="btn-secondary" onclick="toggleEdit({{ $p->id }})">Editar</button>
                </td>
                <td>
                    <form method="POST" action="{{ route('inventario.destroy', $p) }}" onsubmit="return confirm('¿Eliminar este producto?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>

            <tr id="edit-{{ $p->id }}" style="display:none;">
                <td colspan="4">
                    <form method="POST" action="{{ route('inventario.update', $p) }}" class="form-grid-inline">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label>Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $p->name) }}" required>
                        </div>

                        <div>
                            <label>Stock</label>
                            <input type="number" name="stock" value="{{ old('stock', $p->stock) }}" required>
                        </div>

                        <div>
                            <label>Precio</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $p->price) }}" required>
                        </div>

                        <div style="display:flex;gap:.5rem;align-items:center;">
                            <button type="submit" class="btn-primary">Guardar</button>
                            <button type="button" class="btn-secondary" onclick="toggleEdit({{ $p->id }})">Cancelar</button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach

            <script>
                function toggleEdit(id) {
                    var r = document.getElementById('edit-' + id);
                    if (!r) return;
                    r.style.display = (r.style.display === 'table-row') ? 'none' : 'table-row';
                }
            </script>
        </tbody>
       
    </table>
</div>

@endsection
