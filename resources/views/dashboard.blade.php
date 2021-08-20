@extends('layouts.dashboard_app')

@section('welcome')
    {{-- <h1 class="font-weight-bold mb-0">
        Bienvenido <b>{{ auth()->user()->name }}</b>
    </h1>                                 --}}
    <p class="lead text-muted">Dashboard</p>
@endsection

@section('message')
@if(Session::has('message'))
<div id="message" class="mt-0 mb-0 alert alert-{{ Session::get('typealert')}}"  style="margin-top: -16px;">
    {{ Session::get('message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif 
@endsection

@section('content')
    <div class="row"> 
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div id="moveCard" class="card my-1 border-0 shadow-sm shadow-hover">
                <a href="{{ url('/usuarios/administradores') }}">
                    <div class="card-body d-flex justify-content-center">   
                        <div class="circle bg-primary rounded-circle mr-3 d-flex align-self-center">
                            <i class="fas fa-user-shield text-light lead align-self-center mx-auto"></i>
                        </div>     
                        <div>
                            <h6 class="text-muted mb-0">Administradores</h6>
                            <h3 class="font-weight-bold text-center">{{ $admin }}</h3>   
                        </div>              
                    </div>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div id="moveCard" class="card my-1 border-0 shadow-sm shadow-hover">
                <a href="{{ url('/usuarios/usuarios') }}">
                    <div class="card-body d-flex justify-content-center">   
                        <div class="circle bg-primary rounded-circle mr-3 d-flex align-self-center">
                            <i class="fas fa-users text-light lead align-self-center mx-auto"></i>
                        </div>    
                        <div>
                            <h6 class="text-muted mb-0">Usuarios</h6>
                            <h3 class="font-weight-bold text-center">{{ $user }}</h3>   
                        </div>              
                    </div>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div id="moveCard" class="card my-1 border-0 shadow-sm shadow-hover">
                <a href="{{ url('/empresas') }}">
                    <div class="card-body d-flex justify-content-center">   
                        <div class="circle bg-primary rounded-circle mr-3 d-flex align-self-center">
                            <i class="fas fa-building text-light lead align-self-center mx-auto"></i>
                        </div>       
                        <div>
                            <h6 class="text-muted mb-0">Empresas</h6>
                            <h3 class="font-weight-bold text-center">{{ $company }}</h3>   
                        </div>              
                    </div>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div id="moveCard" class="card my-1 border-0 shadow-sm shadow-hover">
                <a href="{{ url('/colaboradores') }}">
                    <div class="card-body d-flex justify-content-center">   
                        <div class="circle bg-primary rounded-circle mr-3 d-flex align-self-center">
                            <i class="fas fa-people-carry text-light lead align-self-center mx-auto"></i>
                        </div>     
                        <div>
                            <h6 class="text-muted mb-0">Colaboradores</h6>
                            <h3 class="font-weight-bold text-center">{{ $collaborator }}</h3>   
                        </div>              
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection