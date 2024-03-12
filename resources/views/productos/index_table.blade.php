<!-- resources/views/productos/index_table.blade.php -->
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
   