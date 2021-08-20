@extends('layouts.dashboard_app')

@section('content')
    @section('welcome')
        <p class="lead text-muted">Dashboard/Colaboradores</p>
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
    <div class="row">
        <div class="col-xl-8 col-lg-8 pb-3">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="font-weight-bold mb-0">Nuestros Colaboradores</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 clearfix pb-3">
                            <form action="{{ Route('colaboradores.show') }}" method="GET">
                                <div class="form-row">
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="texto" value="{{ $search }}">
                                    </div>
                                    <div class="col-4">
                                        <input type="submit" class="btn btn-success" value="Buscar">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                            <div class="pl-2 float-right">
                                {{ $colaboradores->links() }}
                            </div>
                        </div>
                        <div class="col-xl-12">
                            @if (count($colaboradores) == 0)
                                <div class="row">
                                    <p class="mx-auto font-weight-bold mb-0">
                                        No Hay Registros Disponibles
                                    </p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table id="table" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center" scope="col">#</th>
                                                <th class="text-center" scope="col">Nombre</th>
                                                <th class="text-center" scope="col">Apellido</th>
                                                <th class="text-center" scope="col">Empresa</th>
                                                <th class="text-center" scope="col">Correo Electronico</th>
                                                <th class="text-center" scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $contador = 1    
                                            @endphp 
                                            @foreach ($colaboradores as $colaborador)
                                                <tr>
                                                    <th>
                                                        {{ $contador++ }}
                                                    </th>
                                                    <td>
                                                        {{ $colaborador->name }}
                                                    </td>
                                                    <td>
                                                        {{ $colaborador->last_name }}
                                                    </td>
                                                    <td>
                                                        {{ $colaborador->collaborators }}
                                                    </td>
                                                    <td>
                                                        {{ $colaborador->email }}
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{url('/colaboradores/edit/'.$colaborador->id)}}" class="btn btn-primary btn-sm my-1" style="width: 65px">Editar</a>
                                                        <a data-togglee="tooltip" class="btn btn-danger btn-sm my-1" style="width: 65px" id="{{ $colaborador->id }}" name="{{ $colaborador->name }}" onclick="showModalDeleteJs(this.id, this.name , '/colaboradores/delete/')">Eliminar</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $colaboradores->links() }}
                                </div>
                            @endif
                        </div>
                    </div>   
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="font-weight-bold mb-0">Agregar Nuevo Colaborador</h6>
                </div>
                <div class="card-body">
                    <form id="form-data" method="POST" action="{{ url('/colaboradores') }}"> 
                        @csrf
                        <div class="row">
                            <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="{{ old('name') }}">
                                @error('name')
                                    <small class="text-danger mt-0 pt-0">*{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellido" value="{{ old('last_name') }}">
                                @error('last_name')
                                    <small class="text-danger mt-0 pt-0">*{{$message}}</small>
                                @enderror
                            </div>
                            
                            <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="input-group-text text-success" data-toggle="modal" data-target="#addNewCompanies">
                                            <i class="fas fa-plus" title="Agregar otra empresa"></i>
                                        </button>
                                    </div>
                                    <select class="custom-select" name="company_id" id="company_id">
                                        <option selected>***Seleccione una Empresa***</option>
                                        @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->id }}">{{$empresa->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('company_id')
                                    <small class="text-danger mt-0 pt-0">*{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Correo electronico" value="{{ old('email') }}">
                                @error('email')
                                    <small class="text-danger mt-0 pt-0">*{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Número de telefono" value="{{ old('phone') }}">
                                @error('phone')
                                    <small class="text-danger mt-0 pt-0">*{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                    <button type="submit" class="btn btn-success btn-block rounded-pill shadow-hover mb-0" ">Agregar Colaborador</button>
                            </div>
                        </div>
                    </form>  
                </div>
            </div>
        </div>
    </div>
@endsection 