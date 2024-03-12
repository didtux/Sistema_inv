@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h4 class="page__heading">Bienvenido, {{ \Illuminate\Support\Facades\Auth::user()->name }}</h4>
    </div>

    <div class="row">
        <div class="col-md-6">
            <canvas id="graficoProductos"></canvas>
            <div class="mt-3">
                {{ $productos->appends(request()->except('productos_page'))->links('pagination::bootstrap-4', ['pageName' => 'productos_page']) }}
            </div>
        </div>
        <div class="col-md-6">
            <canvas id="graficoVentasPorFecha"></canvas>
            <div class="mt-3">
                {{ $ventasPorFecha->appends(request()->except('ventas_page'))->links('pagination::bootstrap-4', ['pageName' => 'ventas_page']) }}
            </div>
        </div>
        <div class="col-md-6">
            <canvas id="graficoIngresosPorFecha"></canvas>
            <div class="mt-3">
                {{ $ingresosPorFecha->appends(request()->except('ingresos_page'))->links('pagination::bootstrap-4', ['pageName' => 'ingresos_page']) }}
            </div>
        </div>
        <div class="col-md-6">
            <canvas id="graficoTraspasosPorFecha"></canvas>
            <div class="mt-3">
                {{ $traspasosPorFechaEnviados->appends(request()->except('enviados_page'))->links('pagination::bootstrap-4', ['pageName' => 'enviados_page']) }}
                {{ $traspasosPorFechaRecibidos->appends(request()->except('recibidos_page'))->links('pagination::bootstrap-4', ['pageName' => 'recibidos_page']) }}
            </div>
        </div>
    </div>
</section>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de Barras de Productos
        var ctxProductos = document.getElementById('graficoProductos').getContext('2d');
        var graficoProductos = new Chart(ctxProductos, {
            type: 'bar',
            data: {
                labels: @json($productos->pluck('nombre')),
                datasets: [{
                    label: 'Cantidad de Productos',
                    data: @json($productos->pluck('cantidad')),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de Líneas de Ventas por Fecha
        var ctxVentasPorFecha = document.getElementById('graficoVentasPorFecha').getContext('2d');
        var graficoVentasPorFecha = new Chart(ctxVentasPorFecha, {
            type: 'line',
            data: {
                labels: @json($ventasPorFecha->pluck('fecha')),
                datasets: [{
                    label: 'Cantidad de productos vendidos',
                    data: @json($ventasPorFecha->pluck('total_ventas')),
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
  
        // Gráfico de Líneas de Ingresos por Fecha
        var ctxIngresosPorFecha = document.getElementById('graficoIngresosPorFecha').getContext('2d');
        var graficoIngresosPorFecha = new Chart(ctxIngresosPorFecha, {
            type: 'line',
            data: {
                labels: @json($ingresosPorFecha->pluck('fecha')),
                datasets: [{
                    label: 'Ingresos por Fecha',
                    data: @json($ingresosPorFecha->pluck('total_ingresos')),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value, index, values) {
                                return value + ' Bs';
                            }
                        }
                    }
                }
            }
        });

        // Gráfico de Barras de Traspasos Enviados y Recibidos por Fecha
        var ctxTraspasosPorFecha = document.getElementById('graficoTraspasosPorFecha').getContext('2d');
        var graficoTraspasosPorFecha = new Chart(ctxTraspasosPorFecha, {
            type: 'bar',
            data: {
                labels: @json($traspasosPorFechaEnviados->pluck('fecha')),
                datasets: [{
                    label: 'Traspasos Enviados',
                    data: @json($traspasosPorFechaEnviados->pluck('total_traspasos')),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'Traspasos Recibidos',
                    data: @json($traspasosPorFechaRecibidos->pluck('total_traspasos')),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
