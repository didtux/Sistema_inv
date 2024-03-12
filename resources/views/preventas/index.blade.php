@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Preventas</h3>
        </div>
        <a href="{{ route('preventas.create') }}" class="btn btn-primary mb-3">Agregar Preventa</a>
        <div>
            <a href="{{ route('preventas.index') }}" class="btn btn-primary mb-3">Ver todas las Preventas</a>
        </div>
        <form action="{{ route('preventas.index') }}" method="get">
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre de cliente" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" name="filter" value="today" class="btn btn-info btn-block">Hoy</button>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="filter" value="month" class="btn btn-info btn-block">Este Mes</button>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" name="filter" value="year" class="btn btn-info btn-block">Este Año</button>
                        </div>
                    </div>
                    
                    <div class="input-group mt-2">
                        <input type="date" name="specific_date" class="form-control">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-info">Fecha Específica</button>
                        </div>
                    </div>
        
                    <div class="input-group mt-2">
                        <select name="specific_month" class="form-control" placeholder="Selecciona un mes">
                            <option value="" disabled selected>Selecciona un mes</option>
                            @for ($month = 1; $month <= 12; $month++)
                                <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                    {{ \Carbon\Carbon::create(2022, $month, 1)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-info">Mes Específico</button>
                        </div>
                    </div>
        
                    <div class="input-group mt-2">
                        <input type="number" name="specific_year" class="form-control" placeholder="Año">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-info">Año Específico</button>
                        </div>
                    </div>
                </div>
                <h3>Periodos de tiempo</h3>
                <div class="col-md-4">
                    <div class="input-group"> 
                        <input type="date" name="start_date" class="form-control" placeholder="Fecha de inicio" value="{{ request('start_date') }}">
                        <div class="input-group-append">
                            <span class="input-group-text">a</span>
                        </div>
                        <input type="date" name="end_date" class="form-control" placeholder="Fecha de fin" value="{{ request('end_date') }}">
                    </div>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>
        
        <div class="row">
            @foreach($preventas as $preventa)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header" style="font-size: 18px;">
                            <strong> Nota de preventa</strong>
                        </div>
                        
                        <div class="card-body">
                            <p class="card-text" style="font-size: 16px;"><strong>Detalles:</strong></p>
                            <p class="card-text"><strong>Usuario:</strong> {{ $preventa->usuario->name }}</p>
                            <p class="card-text"><strong>Tienda:</strong> {{ $preventa->tienda->nombre }}</p>
                            <p class="card-text"><strong>Nombre del Cliente:</strong> {{ $preventa->nombre_cliente }}</p>
                            <p class="card-text"><strong>Teléfono del Cliente:</strong> {{ $preventa->tel_cliente }}</p>
                            <p class="card-text"><strong>Cantidad:</strong> {{ $preventa->cantidad }} unidades.</p>
                            <p class="card-text"><strong>Precio del producto:</strong> {{ $preventa->precio }} Bs.</p>
                            <p class="card-text"><strong>Precio total:</strong> {{ $preventa->precio_total }} Bs.</p>
                            <p class="card-text">
                                <strong>Fecha de Creación:</strong>
                                {{ \Carbon\Carbon::parse($preventa->created_at)->subHours(4)->format('d/m/Y H:i') }}
                            </p>
                            @php
                            $whatsappMessage = "¡Hola! Aquí están los detalles de su preventa:%0A";
                            $whatsappMessage .= "Tienda: " . urlencode($preventa->tienda->nombre) . "%0A";
                            $whatsappMessage .= "Nombre del Cliente: " . urlencode($preventa->nombre_cliente) . "%0A";
                           
                            $whatsappMessage .= "Nombre del producto: " . $preventa->producto->nombre . ", ";
                            $whatsappMessage .= "Cantidad: " . urlencode($preventa->cantidad) . "%0A";
                            $whatsappMessage .= "Precio del producto: " . urlencode($preventa->precio . " Bs.") . "%0A";
                            $whatsappMessage .= "Precio Total:" . urlencode($preventa->precio_total . " Bs.") . "%0A";

                            $whatsappMessage .= "Fecha de Creación: " . urlencode(\Carbon\Carbon::parse($preventa->created_at)->subHours(4)->format('d/m/Y H:i'));
                        @endphp
                       <a href="#" class="btn btn-success enviar-whatsapp" data-number="{{ $preventa->tel_cliente }}" data-message="{{ $whatsappMessage }}">
                        <i class="fab fa-whatsapp"></i> Enviar preventa por WhatsApp
                    </a>
                    
                        <div class="d-flex justify-content-between mt-3">
                   @can('gerente')
                            <form action="{{ route('preventas.destroy', $preventa->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $preventas->links() }}
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Agregar un evento de clic a los botones de enviar WhatsApp
        var buttons = document.getElementsByClassName('enviar-whatsapp');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].addEventListener('click', function(e) {
                e.preventDefault();
                var number = this.getAttribute('data-number');
                var message = this.getAttribute('data-message');
                window.open('https://api.whatsapp.com/send?phone=' + number + '&text=' + message, '_blank');
            });
        }
    });
</script>
@endsection
