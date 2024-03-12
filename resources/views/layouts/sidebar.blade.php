<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <img src="{{ asset('storage/' . optional($configuracion)->logo_path) }}" alt="logo" width="50" class="shadow-light" alt=" Logo">
        <a href="{{ url('/') }}"></a>
        <span>{{ optional($configuracion)->nombre_sistema }}</span>
    </div>
    
    <div class="sidebar-brand sidebar-brand-sm">
        <div class="sidebar-brand">
            <img src="{{ asset('storage/' . optional($configuracion)->logo_path) }}" alt="logo" width="50" class="shadow-light" alt=" Logo">
            <span>{{ optional($configuracion)->nombre_sistema }}</span>
        </div>
    </div>
    <ul class="sidebar-menu">
        @include('layouts.menu')
    </ul>
</aside>
