@extends('layouts.login_app')

@section('title','Login')
    
@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card">
                    <div class="card-header bg-gray">
                        <h2 class="text-dark text-center">Inicio de Sesión</h2>
                    </div>
                    <div class="card-body pt-4">
                        @if(Session::has('message'))
                            <div id="message" class="mt-0 mb-0 alert 
                                alert-{{ Session::get('typealert')}}" >
                                {{ Session::get('message')}}
                            </div>
                        @endif 
                        <form action="/login" class="pt-4"  method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control rounded-pill" id="email" name="email"  placeholder="Correo Electrónico">
                                @error('email')
                                    <small class="text-danger">*{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control rounded-pill" id="password" name="password" placeholder="Contraseña">
                                @error('password')
                                    <small class="text-danger">*{{$message}}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <button type="submit" class="btn btn-purple rounded-pill w-100 mt-3 mb-4">Iniciar Sesión</button>
                                </div>
                            </div>  
                            <div class="text-center">
                                <a href="#">¿Olvido su Contraseña?</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center bg-gray">
                        <a id="link" href="/register">
                            ¿No Tiene un Usuario? Regístrese Aquí
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection