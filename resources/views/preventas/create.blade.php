@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Realizar Venta</h3>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('preventas.store') }}" method="post" id="ventaForm">
            @csrf
            <div class="form-group">
                <label for="producto_id">Producto:</label>
                <select name="producto_id" class="form-control" id="productoSelect" required>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" data-precio1="{{ $producto->precio1 }}" data-precio2="{{ $producto->precio2 }}">
                            {{ $producto->nombre }} Cantidad en stock:{{ $producto->cantidad }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <select name="precio" class="form-control" id="precioSelect" required disabled>
                 
                </select>
           
            </div>
            <div class="form-group">
                <label for="tienda_id">Ubicación:</label>
                <select name="tienda_id" class="form-control" required>
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nombre_cliente">Nombre Cliente:</label>
                <input type="text" name="nombre_cliente" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="tel_cliente">Teléfono Cliente:</label>
                <input type="text" name="tel_cliente" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" class="form-control" id="cantidadInput" required>
            </div>
            <div class="form-group">
                <label for="precio_total">Precio Total:</label>
                <input type="text" name="precio_total" class="form-control" id="precioTotal" readonly>
            </div>
            <button type="button" class="btn btn-primary" id="calcularTotal">Calcular Total</button>
            <button type="submit" class="btn btn-success" id="realizarVenta" style="display: none;">Realizar Venta</button>
        </form>
    </div>

    <script>
        // Script para actualizar las opciones de precio al cambiar el producto seleccionado
        var productoSelect = document.getElementById('productoSelect');
        var precioSelect = document.getElementById('precioSelect');
        var cantidadInput = document.getElementById('cantidadInput');
        var precioTotalInput = document.getElementById('precioTotal');
        var realizarVentaBtn = document.getElementById('realizarVenta');
    
        productoSelect.addEventListener('change', function () {
            var selectedProduct = this.options[this.selectedIndex];
            var precio1 = selectedProduct.getAttribute('data-precio1');
            var precio2 = selectedProduct.getAttribute('data-precio2');
    
            // Limpiar las opciones anteriores
            precioSelect.innerHTML = '';
    
            // Agregar las nuevas opciones
            if (precio1) {
                precioSelect.innerHTML += '<option value="' + precio1 + '">Precio 1: ' + precio1 + '</option>';
            }
            if (precio2) {
                precioSelect.innerHTML += '<option value="' + precio2 + '">Precio 2: ' + precio2 + '</option>';
            }
    
            // Habilitar el campo de precio y limpiar el campo de precio total
            precioSelect.disabled = false;
            precioTotalInput.value = '';
            realizarVentaBtn.style.display = 'none';
        });
        
    
        // Script para calcular el precio total 
        document.getElementById('calcularTotal').addEventListener('click', function () {
            var cantidad = parseFloat(cantidadInput.value);
            var precio = parseFloat(precioSelect.value);
            var precioTotal = cantidad * precio;
    
            // Mostrar el precio total en el campo correspondiente
            precioTotalInput.value = precioTotal.toFixed(2);
    
            // Mostrar el botón "Realizar Venta" si el precio total es mayor a 0
            if (precioTotal > 0) {
                realizarVentaBtn.style.display = 'inline-block';
            } else {
                realizarVentaBtn.style.display = 'none';
            }
        });
    </script>
    
@endsection
