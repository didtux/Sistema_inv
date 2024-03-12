
@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Sucursales</h3>
    </div>
        <a href="{{ route('sucursal.create') }}" class="btn btn-primary mb-3">Agregar Sucursal</a>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped mt-2">
            <thead style="background-color:#2330ec">
           
                <tr>
                    <th style="display: none;">ID</th>
                    <th style="color:#fff">Nombre</th>
                    <th style="color:#fff">Ubicación</th>
                    <th style="color:#fff">Teléfono</th>
                    <th style="color:#fff">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sucursales as $sucursal)
                    <tr>
                        <td style="display: none;">{{ $sucursal->id }}</td>
                        <td >{{ $sucursal->nombre }}</td>
                        <td>{{ $sucursal->ubicacion }}</td>
                        <td>{{ $sucursal->telefono }}</td>
                        <td>
                       
                            <a href="{{ route('sucursal.edit', $sucursal->id) }}" class="btn btn-warning">Editar</a>
                            @can('admin')
                            <form action="{{ route('sucursal.destroy', $sucursal->id) }}" method="POST" style="display: inline;">

                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta sucursal?')">Eliminar</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
