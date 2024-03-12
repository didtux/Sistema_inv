<?php

use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\PreventaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\TraspasoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('sucursal', SucursalController::class);
Route::get('/productos/search', [ProductoController::class, 'search'])->name('productos.search');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('productos', ProductoController::class);
Route::get('/traspasos/enviar_producto', [TraspasoController::class, 'showFormEnviarProducto'])->name('traspasos.showFormEnviarProducto');
Route::post('/traspasos/enviar_producto', [TraspasoController::class, 'enviarProducto'])->name('traspasos.enviarProducto');

Route::get('/traspasos/recibir_producto', [TraspasoController::class, 'showFormRecibirProducto'])->name('traspasos.showFormRecibirProducto');
Route::post('/traspasos/recibir_producto', [TraspasoController::class, 'recibirProducto'])->name('traspasos.recibirProducto');


Route::patch('usuarios/{user}/change-status', [UsuarioController::class, 'changeStatus'])->name('usuarios.change-status');



Route::get('/configuracion', [ConfiguracionController::class, 'mostrarConfiguracion'])->name('configuracion.mostrar');
Route::put('/configuracion', [ConfiguracionController::class, 'actualizarConfiguracion'])->name('configuracion.update');


Route::post('productos/cambiar-estado/{producto}', [ProductoController::class,'cambiarEstado'])->name('productos.cambiarEstado');


Route::get('/ventas/pdf', [VentaController::class, 'generatePDF'])->name('ventas.generatePDF');
Route::resource('roles', RolController::class);
Route::resource('usuarios', UsuarioController::class);
Route::resource('traspasos', TraspasoController::class);
Route::resource('ventas', VentaController::class);

Route::resource('preventas', PreventaController::class);



Auth::routes();
