<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
   

    public function index()
    {
        $roles =Role::paginate(5);
        return view('roles.index',compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission=Permission::get();
        return view('roles.crear',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required|array', // Aseguramos que 'permission' sea un array
            'description' => 'nullable',
        ]);
    
        try {
          
            $role = Role::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);
    
            if ($request->has('permission')) {
                $permissions = Permission::whereIn('id', $request->input('permission'))->get();
                $role->syncPermissions($permissions);
            }
    
            return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
        } catch (\Exception $e) {
           
            return redirect()->route('roles.index')->withErrors(['name' => 'Error al crear el rol, nombre del rol ya asignado.']);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.    
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role=  Role::find($id);
        $permission=Permission::get();
        $rolePermissions= DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
  
        return view('roles.editar',compact('role','permission','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'nullable',
            'permission' => 'required|array',
        ]);
    
        try {
            $role = Role::find($id);
    
            if (!$role) {
                return redirect()->route('roles.index')->withErrors(['name' => 'Rol no encontrado.']);
            }
    
            $role->name = $request->input('name');
            $role->description = $request->input('description');
            $role->save();
    
            if ($request->has('permission')) {
                $permissions = Permission::whereIn('id', $request->input('permission'))->get();
                $role->syncPermissions($permissions);
            }
    
            return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->withErrors(['name' => 'Error al actualizar el rol.']);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('roles')->where('id',$id)->delete();
        return redirect()->route('roles.index');
    }
}
