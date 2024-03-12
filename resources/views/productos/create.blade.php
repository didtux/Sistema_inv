
@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Agregar producto</h3>
    </div>
        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombre del producto:</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="codigo1">Código 1:</label>
                        <input type="text" name="codigo1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="codigo2">Código 2:</label>
                        <input type="text" name="codigo2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" name="descripcion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="precio1">Precio 1:</label>
                        <input type="number" name="precio1" step="0.01" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="precio2">Precio 2:</label>
                        <input type="number" name="precio2" step="0.01" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="marca">Marca:</label>
                        <input type="text" name="marca" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto:</label>
                        <input type="file" name="foto" class="form-control-file">
                    </div>
                    <div class="form-group">
                        <label for="ubicacion">Ubicación:</label>
                        <select name="ubicacion[]" class="form-control select2" multiple="multiple" required>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    
     
                    
                    <div class="form-group">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" name="cantidad" class="form-control" required>
                    </div>
                    <input type="hidden" name="estado" value="activo">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Producto</button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/js/select2.min.js"></script>
@endsection
