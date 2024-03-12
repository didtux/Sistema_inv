@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Productos</h3>
    </div>
    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Agregar Producto</a>
    <div>
        <a href="{{ route('productos.index') }}" class="btn btn-primary mb-3">Ver todos los  productos</a>
    </div>
  <input type="text" id="searchInput" name="q" class="form-control" placeholder="Buscar productos por nombre, codigo y descripcion" onkeyup="searchProducts()">
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
@if(isset($error))
    <div class="alert alert-danger">
        {{ $error }}
    </div>
@endif

    <div class="table-responsive">
        <table class="table table-striped mt-2" id="productTable">
            <thead style="background-color:#2330ec">
                <tr>
                    <th style="color:#fff">Nombre del producto</th>
                    <th style="color:#fff">Código 1</th>
                    <th style="color:#fff">Código 2</th>
                    <th style="color:#fff">Descripción</th>
                    <th style="color:#fff">Precio 1</th>
                    <th style="color:#fff">Precio 2</th>
                    <th style="color:#fff">Marca</th>
                    <th style="color:#fff">Foto</th>
                    <th style="color:#fff">Ubicación</th>
                    <th style="color:#fff">Cantidad</th>
                    <th style="color:#fff">Estado</th>
                    @can('gerente')
                    <th style="color:#fff">Acciones</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)

                     <tr style="margin-bottom: 15px;">
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->codigo1 }}</td>
                        <td>{{ $producto->codigo2 }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ number_format($producto->precio1, 2) }}Bs.</td>
                        <td>{{ number_format($producto->precio2, 2) }}Bs.</td>
                        <td>{{ $producto->marca }}</td>
                        <td>
                            @if($producto->foto)
                                <img src="{{ asset('storage/' . $producto->foto) }}" alt="Imagen de {{ $producto->nombre }}" style="max-width: 100px;">
                            @else
                                No disponible
                            @endif
                        </td>
                        <td>
                            @foreach($producto->ubicaciones as $ubicacion)
                                {{ $ubicacion->nombre }},
                            @endforeach
                        </td>
                        <td>{{ $producto->cantidad }} Unidades</td>
                        <td>{{ ucfirst($producto->estado) }}</td>
                        @can('gerente')
                        <td>
                            <div>
                                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-sm" style="margin-right: 5px;">Editar</a>
                                @can('admin')
                                <form action="{{ route('productos.cambiarEstado', $producto) }}" method="POST" style="display: inline; margin-left: 5px; margin-top:10px;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" style="display: inline; margin-top:10px;">Cambiar Estado</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                        
                        @endcan
                   
                @endforeach
            </tbody>
    
            
            <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
           <script>
      function searchProducts() {
    var searchTerm = $("#searchInput").val();

    if (searchTerm.length > 2) {
        $.ajax({
            url: "{{ route('productos.search') }}",
            type: "GET",
            data: { q: searchTerm },
            dataType: 'json', // Espera JSON en la respuesta
            success: function(data) {
                // Actualiza solo la sección de la tabla
                $("#productTable tbody").html(data.tableHtml);
            },
            error: function(error) {
                console.error("Error:", error);
            }
        });
    } else {
        $("#productTable tbody").html(""); // Limpia la tabla si la búsqueda está vacía
    }
}


            </script>
                
        </table>
    </div>
    {{ $productos->links() }}
</section>
@endsection
