@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Editar Preventa</h3>
        </div>

        <form action="{{ route('preventas.update', $preventa->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="producto_id">Producto:</label>
                <select name="producto_id" class="form-control" required>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ $preventa->producto_id == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tienda_id">Tienda:</label>
                <select name="tienda_id" class="form-control" required>
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}" {{ $preventa->tienda_id == $ubicacion->id ? 'selected' : '' }}>
                            {{ $ubicacion->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="nombre_cliente">Nombre del Cliente:</label>
                <input type="text" name="nombre_cliente" class="form-control" value="{{ $preventa->nombre_cliente }}" required>
            </div>

            <div class="form-group">
                <label for="tel_cliente">Teléfono del Cliente:</label>
                <input type="text" name="tel_cliente" class="form-control" value="{{ $preventa->tel_cliente }}" required>
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" class="form-control" value="{{ $preventa->cantidad }}" required>
            </div>

            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" name="precio" class="form-control" value="{{ $preventa->precio }}" required>
            </div>



            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>

    </section>
@endsection
