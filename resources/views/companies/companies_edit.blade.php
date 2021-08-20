@extends('layouts.dashboard_app')

@section('welcome')
    <p class="lead text-muted">Dashboard/Editar Empresas</p>
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
        <div class="col-xl-8 col-lg-8 pb-3"> 
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="font-weight-bold mb-0">Nuestras Empresas</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div  class="col-xl-6 col-lg-6 col-md-6 col-sm-6 clearfix pb-3">
                            <form action="{{ Route('empresas.show') }}" method="GET">
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
                                {{ $empresas->links() }}
                            </div>
                        </div>
                        <div class="col-xl-12">
                            @if (count($empresas) == 0)
                                <div class="row">
                                    <p class="mx-auto font-weight-bold mb-0">
                                        No Hay Registros Disponibles
                                    </p>
                                </div>
                            @endif
                        </div>
                        @foreach ($empresas as $row)
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 d-flex py-2">
                                <div class="card mx-auto" style="width: 14rem;">
                                    <div id="card-header" class="card-header ">
                                        <a class="text-success" id="btnModalInfo" data-toggle="modal" data-target="#modalInfo" data-emp="{{ $empresa->name }}" data-ema="{{ $empresa->email }}" data-web="{{ $empresa->web_site }}">
                                            <div class="float-right">
                                                <i class="far fa-eye"></i>
                                            </div>
                                        </a>
                                        @if ($row->photo != null)
                                            <img class="card-img-top image-card text-center" id="min-max-img" src="{{ Storage::url($row->photo) }}" alt="Card image cap">
                                        @else 
                                            <img class="card-img-top image-card text-center" id="min-max-img" src="{{ Storage::url('public/logo.jpg') }}" alt="Card image cap">
                                        @endif
                                    </div>
                                    <div class="card-body bg-light">
                                        <h5 class="card-title">
                                            {{ $row->name }}
                                        </h5>
                                        <div class="row">
                                            <div class="col align-self-center">
                                                <a href="{{url('/empresas/edit/'.$row->id)}}" class="btn btn-primary btn-sm mb-2 w-100">Editar</a>
                                            </div>
                                            <div class="col align-self-center">
                                                <a data-togglee="tooltip" class="btn btn-danger btn-sm mb-2 w-100" id="{{ $row->id }}" name="{{ $row->name }}" onclick="showModalDeleteJs(this.id, this.name , '/empresas/delete/')">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="pl-4">
                    {{ $empresas->links() }}
                </div>
            </div>    
        </div>
        <div class="col-xl-4 col-lg-4">
            <div class="card" id="card-height">
                <div class="card-header bg-light">
                    <h6 class="font-weight-bold mb-0">Modificar Empresa <b>{{ $empresa->name }}</b></h6>
                </div>
                <div class="card-body"> 
                    <div>
                        <form id="form-data" method="POST" action="{{ url('/empresas/edit/'.$empresa->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row"> 
                                <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la Empresa" value="{{ old('name', $empresa->name) }}" autofocus required>
                                    @error('name')
                                        <small class="text-danger">*{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Correo electronico" value="{{ old('email', $empresa->email) }}">
                                    @error('email')
                                        <small class="text-danger">*{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6 mb-3">
                                    <label for="photo">Logo de la Empresa</label>
                                    <div class="custom-file mb-2">
                                        <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*">
                                        <label class="custom-file-label" for="photo">
                                            Mínimo 100 × 100
                                        </label>
                                    </div>
                                    <div  class="d-flex">
                                        <div id="imagePreview" class="mx-auto">
                                            @if (isset($empresa->photo))
                                                <img class="img-thumbnail img-fluid" width="100px"  src="{{ Storage::url($empresa->photo) }}" alt="{{'Imagen del producto '.$empresa->name}}">
                                            @else
                                                <img class="img-thumbnail img-fluid" width="100px" height="100" src="{{ Storage::url('logo.jpg') }}" alt="{{'Imagen del producto '.$empresa->name}}">
                                            @endif
                                        </div>
                                    </div>
                                    @error('photo')
                                        <small class="text-danger">*{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                    <label for="web_site">Sitio Web</label>
                                    <input type="text" class="form-control " id="web_site" name="web_site" placeholder="https://www.empresa.com" value="{{ old('web_site',$empresa->web_site) }}">
                                    @error('web_site')
                                        <small class="text-danger">*{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6 d-flex">
                                    <div class="mx-auto">
                                        <button type="submit" class="btn btn-success mb-2 rounded-pill shadow-hover w-100">Guardar Cambios</button>
                                        <a href="{{ url('/empresas') }}" class="btn btn-primary mb-2 rounded-pill shadow-hover w-100">
                                            Volver Atrás
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>
                            </form> 
                    </div> 
                </div>
            </div>
        </div>
    </div>
@endsection