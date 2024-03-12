@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Configuración</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4>Configuración de Traspasos</h4>
            </div>
            <div class="card-body">
                @if($configuracion)
                    <p>Última cantidad máxima: {{ $configuracion->cantidad_maxima }}</p>
                    <p>Nombre del sistema: {{ $configuracion->nombre_sistema }}</p>
                    @if($configuracion->logo_path)
                        <img src="{{ asset('storage/' . $configuracion->logo_path) }}" alt="logo" width="100">
                    @endif
                @endif

                <form action="{{ route('configuracion.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="cantidad_maxima">Nueva Cantidad Máxima:</label>
                        <input type="number" name="cantidad_maxima" class="form-control" value="{{ old('cantidad_maxima', $configuracion->cantidad_maxima ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="nombre_sistema">Nombre del Sistema:</label>
                        <input type="text" name="nombre_sistema" class="form-control" value="{{ old('nombre_sistema', $configuracion->nombre_sistema ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label for="logo">Nuevo Logo:</label>
                        <input type="file" name="logo" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </section>
@endsection
