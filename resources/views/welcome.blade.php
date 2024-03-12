@extends('layouts.auth_app')

@section('title')
    Iniciar Sesión
@endsection

@section('content')
<div class="card">
    <div class="card-header"><h4>Iniciar Sesión</h4></div>

    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger p-2 mb-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
                <label for="email">Correo</label>
                <input aria-describedby="emailHelpBlock" id="email" type="email"
                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                    placeholder="Correo" tabindex="1"
                    value="{{ (Cookie::get('email') !== null) ? Cookie::get('email') : old('email') }}" autofocus
                    required>
                <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                </div>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input aria-describedby="passwordHelpBlock" id="password" type="password"
                    value="{{ (Cookie::get('password') !== null) ? Cookie::get('password') : null }}"
                    placeholder="Contraseña"
                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                    tabindex="2" required>
                <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="3">
                    Iniciar Sesión
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
