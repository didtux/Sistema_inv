<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="/home">
        <i class="fas fa-tachometer-alt"></i><span>Inicio</span>
    </a>
</li>
@can('admin')
<li class="side-menus {{ Request::is('usuarios*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('usuarios.index') }}">
        <i class="fas fa-users"></i><span>Usuarios</span>
    </a>
</li>
<li class="side-menus {{ Request::is('roles*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('roles.index') }}">
        <i class="fas fa-user-tag"></i><span>Roles</span>
    </a>
</li>
@endcan

<li class="side-menus {{ Request::is('productos*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('productos.index') }}">
        <i class="fas fa-box"></i><span>Productos</span>
    </a>
</li>
@can('gerente')
<li class="side-menus {{ Request::is('sucursal*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('sucursal.index') }}">
        <i class="fas fa-store"></i><span>Sucursales</span>
    </a>
</li>
<li class="side-menus {{ Request::is('traspasos*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('traspasos.index') }}">
        <i class="fas fa-exchange-alt"></i><span>Traspasos</span>
    </a>
</li>
@endcan
<li class="side-menus {{ Request::is('ventas*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('ventas.index') }}">
        <i class="fas fa-cash-register"></i><span>Ventas</span>
    </a>
</li>
<li class="side-menus {{ Request::is('preventas*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('preventas.index') }}">
        <i class="fas fa-dollar-sign"></i><span>Preventas</span>
    </a>
</li>


<li class="side-menus {{ Request::is('configuracion*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('configuracion.mostrar') }}">
        <i class="fas fa-cogs"></i><span>Configuración</span>
    </a>
</li>

    