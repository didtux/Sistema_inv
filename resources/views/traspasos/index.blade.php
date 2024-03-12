@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Traspasos</h3>
        </div>

        <div class="mb-3">
            <a href="{{ route('traspasos.showFormEnviarProducto') }}" class="btn btn-primary">Enviar Producto</a>
            <a href="{{ route('traspasos.showFormRecibirProducto') }}" class="btn btn-primary">Recibir Producto</a>
        </div>
<div>
    <a href="{{ route('traspasos.index') }}" class="btn btn-primary">Ver todos los productos</a>
</div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('traspasos.index') }}" method="get" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="search">Buscar por nombre:</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="estado">Filtrar por estado:</label>
                    <select name="estado" class="form-control">
                        <option value="">Todos</option>
                        <option value="enviado" {{ request('estado') == 'enviado' ? 'selected' : '' }}>Enviado</option>
                        <option value="recibido" {{ request('estado') == 'recibido' ? 'selected' : '' }}>Recibido</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>


        <h4>Todos los Traspasos</h4>
        <div class="table-responsive">
            <table class="table table-striped mt-2">
                <thead style="background-color:#2330ec">
                <tr>
                    <th style="display: none;">ID</th>
                    <th style="color:#fff">Producto</th>
                    <th style="color:#fff">Usuario</th>
                    <th style="color:#fff">Sucursal Origen</th>
                    <th style="color:#fff">Sucursal Destino</th>
                    <th style="color:#fff">Cantidad</th>
                    <th style="color:#fff">Fecha</th>
                    <th style="color:#fff">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($traspasos as $traspaso)
                    <tr>
                        <td style="display: none;">{{ $traspaso->id }}</td>
                        <td>{{ $traspaso->producto->nombre }}</td>
                        <td>{{ $traspaso->usuario->name }}</td>
                        <td>{{ $traspaso->ubicacionOrigen ? $traspaso->ubicacionOrigen->nombre : 'N/A' }}</td>
                        <td>{{ $traspaso->ubicacionDestino ? $traspaso->ubicacionDestino->nombre : 'N/A' }}</td>
                        <td>{{ $traspaso->cantidad }}</td>
                        <td>{{ \Carbon\Carbon::parse($traspaso->fecha)->format('d/m/Y') }}</td>

                        <td>
                            @if($traspaso->estado === 'enviado')
                                <span class="badge badge-success">Enviado</span>
                            @elseif($traspaso->estado === 'recibido')
                                <span class="badge badge-warning">Recibido</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($traspaso->estado) }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $traspasos->links() }}
    </section>
@endsection
