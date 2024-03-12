<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query();

    
        if ($request->has('q')) {
            $q = $request->input('q');
            $query->where('nombre', 'like', "%$q%")
            ->orWhere('descripcion', 'like', "%$q%")
                ->orWhere('codigo1', 'like', "%$q%")
                ->orWhere('codigo2', 'like', "%$q%");
        }

      
        $productos = $query->paginate(10);

        return view('productos.index', compact('productos'));
    }
    public function search(Request $request)
    {
        try {
            $q = $request->input('q');
    
            $query = Producto::query();
            if ($q) {
                $query->where('nombre', 'like', "%$q%")
                      ->orWhere('codigo1', 'like', "%$q%")
                      ->orWhere('descripcion', 'like', "%$q%")
                      ->orWhere('codigo2', 'like', "%$q%");
            }
    
            $productos = $query->get();
    
            // Renderiza la sección de la tabla
            $tableHtml = view('productos.index_table', compact('productos'))->render();
    
            // Devuelve el HTML como parte de un JSON
            return response()->json(['tableHtml' => $tableHtml]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    

    


    public function create()
{
    $ubicaciones = Ubicacion::all();
    return view('productos.create', compact('ubicaciones'));
}
public function store(Request $request)
{

    $request->validate([
        'nombre' => 'required|string|max:255',
        'codigo1' => 'required|string|max:255',
        'codigo2' => 'nullable|string|max:255',
        'descripcion' => 'required|string|max:255',
        'precio1' => 'required|numeric|min:0',
        'precio2' => 'nullable|numeric|min:0',
        'marca' => 'required|string|max:255',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'ubicacion' => 'required|array',
        'cantidad' => 'required|integer|min:0',
        'estado' => 'required|in:activo,inactivo',
    ]);

    $imageRelativePath = null;

    if ($request->hasFile('foto')) {
        $image = $request->file('foto');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = $image->storeAs('public/productos', $imageName);
    
    
        $imageRelativePath = 'productos/' . $imageName;
    }


    $producto = Producto::create([
        'nombre' => $request->nombre,
        'codigo1' => $request->codigo1,
        'codigo2' => $request->codigo2,
        'descripcion' => $request->descripcion,
        'precio1' => $request->precio1,
        'precio2' => $request->precio2,
        'marca' => $request->marca,
        'foto' => $imageRelativePath,
        'cantidad' => $request->cantidad,
        'estado' => $request->estado,
    ]);

  
    $producto->ubicaciones()->attach($request->input('ubicacion'));

    return redirect()->route('productos.index')
        ->with('success', 'Producto creado exitosamente.');
}





public function cambiarEstado( Producto $producto)
{
  

    $nuevoEstado = ($producto->estado === 'activo') ? 'inactivo' : 'activo';
    $producto->update(['estado' => $nuevoEstado]);

    return redirect()->route('productos.index')->with('success', 'Estado del producto cambiado exitosamente.');
}





    

    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {  $ubicaciones = Ubicacion::all();
  
        return view('productos.edit', compact('producto','ubicaciones'));
    }
  
    public function update(Request $request, Producto $producto)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo1' => 'required|string|max:255',
            'codigo2' => 'nullable|string|max:255',
            'descripcion' => 'required|string|max:255',
            'precio1' => 'required|numeric|min:0',
            'precio2' => 'nullable|numeric|min:0',
            'marca' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ubicacion' => 'required|array',
            'cantidad' => 'required|integer|min:0',
        ]);
    
        $imageRelativePath = $producto->foto; 
    
        if ($request->hasFile('foto')) {
        
            Storage::delete('public/' . $producto->foto);
    
          
            $image = $request->file('foto');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('public/productos', $imageName);
    
         
            $imageRelativePath = 'productos/' . $imageName;
        }
    

        $producto->update([
            'nombre' => $request->nombre,
            'codigo1' => $request->codigo1,
            'codigo2' => $request->codigo2,
            'descripcion' => $request->descripcion,
            'precio1' => $request->precio1,
            'precio2' => $request->precio2,
            'marca' => $request->marca,
            'foto' => $imageRelativePath,
            'cantidad' => $request->cantidad,
        ]);
    
    
        $ubicacion = $request->input('ubicacion');
        $producto->ubicaciones()->sync($ubicacion);
    
        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }
    
    
    public function destroy(Producto $producto)
    {
       
        $producto->ubicaciones()->detach();
    
        $producto->delete();
    
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
    

 
}