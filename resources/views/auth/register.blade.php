@extends('layouts.login_app')

@section('title','Registrarse')
    
@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card">
                    <div class="card-header bg-gray">
                        <h2 class="text-dark text-center">Registrarse</h2>
                    </div>
                    <div class="card-body">
                        @if(Session::has('message'))
                            <div class=" mt-3 mb-3 alert alert-{{ Session::get('typealert')}}"  style="margin-top: -16px;">
                            {{ Session::get('message')}}
                            </div>
                        @endif 
                        <form action="/register" class="text-dark" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control rounded-pill" id="name" name="name" placeholder="Nombre" value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger">*{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control rounded-pill" id="last_name" name="last_name" placeholder="Apellido" value="{{ old('last_name') }}">
                                @error('last_name')
                                    <small class="text-danger">*{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control rounded-pill" id="email" name="email" placeholder="Correo Electronico" value="{{ old('email') }}">
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
                            <div class="form-group">
                                <input type="password" class="form-control rounded-pill" id="password2" name="password2" placeholder="Confirme la Contraseña">
                                @error('password2')
                                    <small class="text-danger">*{{$message}}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-xl-12 d-flex">
                                    <button type="submit" class="btn btn-purple rounded-pill w-100 mt-3 mb-4">Registrarse</button>
                                </div>
                            </div>  
                        </form>
                    </div>
                    <div class="card-footer text-center bg-gray">
                        <a href="/login">¿Ya Tienes un Usuario? Ingresa Aquí</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection