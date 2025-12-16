@extends('layouts.app')

@section('content')
<h2> Editar Producto</h2>

<div class="card">
    <form method="POST" action="{{ route('inventario.update', $product) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="name" value="{{ $product->name }}" required>
        </div>

        <div class="form-group">
            <label>Precio</label>
            <input type="number" step="0.01" name="price" value="{{ $product->price }}" required>
        </div>

        <div class="form-group">
            <label>Stock</label>
            <input type="number" name="stock" value="{{ $product->stock }}" required>
        </div>

        <button class="btn-primary">Guardar cambios</button>
        <a href="{{ route('inventario') }}" class="btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
