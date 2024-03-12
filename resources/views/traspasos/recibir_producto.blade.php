@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Recibir producto</h3>
    </div>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>   
        </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
        <form action="{{ route('traspasos.recibirProducto') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="producto_id">Producto:</label>
                <select name="producto_id" class="form-control" required>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }}   Cantidad: {{ $producto->cantidad }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="ubicacion_origen_id">Sucursal de Origen:</label>
                <select name="ubicacion_origen_id" class="form-control" required>
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="ubicacion_destino_id">Sucursal de Destino:</label>
                <select name="ubicacion_destino_id" class="form-control" required>
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Recibir Producto</button>
        </form>
    </div>
@endsection
