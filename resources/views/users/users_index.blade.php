@extends('layouts.dashboard_app')

@section('content')
    @section('welcome')
        <p class="lead text-muted">Dashboard/Usuarios/</p>
    @endsection
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="font-weight-bold mb-0">Usuarios Registrados</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div  class="col-xl-6 col-lg-6 col-md-6 col-sm-6 clearfix pb-3">
                            <form action="{{ Route('usuarios.show') }}" method="GET">
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
                                {{ $usuarios->links() }}
                            </div>
                        </div>
                        <div class="col-xl-12">
                            @if (count($usuarios) == 0)
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
                                                <th class="text-center" scope="col">Correo Electronico</th>
                                                <th class="text-center" scope="col">Permisos</th>
                                                <th class="text-center" scope="col">Estado</th>
                                                <th class="text-center" scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $contador = 1    
                                            @endphp
                                            @foreach ($usuarios as $usuario)
                                                @if ($usuario->id != auth()->user()->id )
                                                    <tr>
                                                        <td class="text-center" scope="row">
                                                            {{ $contador++ }}
                                                        </td>
                                                        <td>
                                                            {{ $usuario->name }}
                                                        </td>
                                                        <td>
                                                            {{ $usuario->last_name }}
                                                        </td>
                                                        <td>
                                                            {{ $usuario->email }}
                                                        </td>
                                                        <td id="role{{ $usuario->id }}"
                                                            class="text-center">      
                                                            @if ($usuario->role == 0)
                                                                Usuario
                                                            @else
                                                                Administrador
                                                            @endif
                                                        </td>
                                                        <td id="resp{{ $usuario->id}}" 
                                                            class="text-center">
                                                            @if ($usuario->role == 0)
                                                                <buttom type="buttom"  style="width: 72px" class="btn btn-sm btn-danger">
                                                                    Inactivo
                                                                </buttom>
                                                            @else
                                                                <buttom type="buttom"  style="width: 72px" class="btn btn-sm btn-success">
                                                                    Activo
                                                                </buttom>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-switch text-center">
                                                                <input data-id="{{ $usuario->id }}" id="{{ $usuario->id }}" class="mi_checkbox custom-control-input" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $usuario->role ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="{{ $usuario->id }}"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach 
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="pl-4">
                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection 