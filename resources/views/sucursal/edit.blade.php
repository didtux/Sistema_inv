
@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar Sucursal</h3>
    </div>
        <form action="{{ route('sucursal.update', $sucursal) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" class="form-control" value="{{ $sucursal->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="ubicacion">Ubicación:</label>
                <input type="text" name="ubicacion" class="form-control" value="{{ $sucursal->ubicacion }}" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" class="form-control" value="{{ $sucursal->telefono }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Sucursal</button>
        </form>
    </div>
@endsection
