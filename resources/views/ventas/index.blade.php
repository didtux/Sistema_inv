@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ventas</h3>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
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
        <div class="mb-3">
            <a href="{{ route('ventas.create') }}" class="btn btn-primary">Realizar Venta</a>
        </div>

        <form action="{{ route('ventas.index') }}" method="get">
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre de producto" value="{{ request('search') }}">
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
                
                <div class="col-md-4">
                    <button type="submit" name="filter" value="today" class="btn btn-info">Hoy</button>
                    <button type="submit" name="filter" value="month" class="btn btn-info">Este Mes</button>
                    <button type="submit" name="filter" value="year" class="btn btn-info">Este Año</button>

                    <div class="input-group">
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
            </div>
            <h3>Periodos de tiempo</h3>
            <div class="row mb-3">
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
        <div class="mb-3">
            <a href="{{ route('ventas.index') }}" class="btn btn-primary">Ver todas las ventas</a>
        </div>

        <form id="downloadPdfForm" action="{{ route('ventas.generatePDF') }}" method="get">
            @csrf
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="filter" value="{{ request('filter') }}">
            <input type="hidden" name="specific_date" value="{{ request('specific_date') }}">
            <input type="hidden" name="specific_month" value="{{ request('specific_month') }}">
            <input type="hidden" name="specific_year" value="{{ request('specific_year') }}">
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            <div class="mb-3">
                <input type="text" id="pdfName" name="pdfName" placeholder="Ingrese el nombre del PDF" required>
                <button type="submit" class="btn btn-success">Descargar PDF</button>
            </div>
        </form>

        <h4>Todas las Ventas</h4>
        <div class="table-responsive">
            <table class="table table-striped mt-2">
                <thead style="background-color:#2330ec">
                    <tr>
                        <th style="display: none;">ID</th>
                        <th style="color:#fff">Producto</th>
                        <th style="color:#fff">Usuario</th>
                        <th style="color:#fff">Sucursal</th>
                        <th style="color:#fff">Cantidad</th>
                        <th style="color:#fff">Precio Unitario</th>
                        <th style="color:#fff">Precio Total</th>
                        <th style="color:#fff">Fecha</th>
                        <th style="color:#fff">Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas as $venta)
                        <tr>
                            <td style="display: none;">{{ $venta->id }}</td>
                            <td>{{ $venta->producto->nombre }}</td>
                            <td>{{ $venta->usuario->name }}</td>
                            <td>{{ $venta->ubicacion->nombre }}</td>
                            <td>{{ $venta->cantidad }}</td>
                            <td>{{ $venta->precio }} Bs.</td>
                            <td>{{ $venta->precio_total }} Bs.  </td>
                            <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($venta->hora)->subHours(4)->format('H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No hay ventas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $ventas->appends(request()->query())->links() }}
        </div>
     
    </section>
    <script>
        document.getElementById('downloadPdfBtn').addEventListener('click', function() {
            // Solicitar al usuario un nombre para el PDF
            var pdfName = prompt("Ingrese el nombre para el PDF", "reporte_ventas");
    
            // Si el usuario proporciona un nombre, generar la URL del PDF con el nombre como parámetro
            if (pdfName !== null) {
                var downloadUrl = "{{ route('ventas.generatePDF', request()->all()) }}" + "&pdfName=" + encodeURIComponent(pdfName);
                window.location.href = downloadUrl;
            }
        });
    </script>
@endsection