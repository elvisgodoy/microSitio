@extends('layouts.dashboard_app')

@section('welcome')
    <p class="lead text-muted">Dashboard/Empresas</p>
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
                        @foreach ($empresas as $empresa)
                            <div  class="col-xl-4 col-lg-4 col-md-6 col-sm-6 d-flex py-2">
                                <div class="card mx-auto" style="width: 14rem;">
                                    <div id="card-header" class="card-header ">
                                        <a class="text-success" id="btnModalInfo" data-toggle="modal" data-target="#modalInfo" data-emp="{{ $empresa->name }}" data-ema="{{ $empresa->email }}" data-web="{{ $empresa->web_site }}">
                                            <div class="float-right">
                                                <i class="far fa-eye"></i>
                                            </div>
                                        </a>
                                        @if ($empresa->photo != null)
                                            <img class="card-img-top image-card text-center"  src="{{ Storage::url($empresa->photo) }}" alt="Imagen de la empresa">
                                        @else 
                                            <img class="card-img-top image-card text-center"  src="{{ Storage::url('public/logo.jpg') }}" 
                                            alt="Imagen de la empresa {{ $empresa->name }}">
                                        @endif
                                    </div>
                                    <div class="card-body bg-light">
                                        <h5 class="card-title">
                                            {{ $empresa->name }}
                                        </h5>
                                        <div class="row">
                                            <div class="col align-self-center">
                                                <a href="{{url('/empresas/edit/'.$empresa->id)}}" class="btn btn-primary btn-sm mb-2 w-100">Editar</a>
                                            </div>
                                            <div class="col align-self-center">
                                                <a data-togglee="tooltip" class="btn btn-danger btn-sm mb-2 w-100" id="{{ $empresa->id }}" name="{{ $empresa->name }}" onclick="showModalDeleteJs(this.id, this.name , '/empresas/delete/')">Eliminar</a>
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
                    <h6 class="font-weight-bold mb-0">Agregar Nueva Empresa</h6>
                </div>
                <div class="card-body"> 
                    <form id="form-data" method="POST" action="{{ url('/empresas') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row"> 
                            <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la Empresa" value="{{ old('name') }}" required>
                                @error('name')
                                    <small class="text-danger">*{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Correo electronico" value="{{ old('email') }}"> 
                                @error('email')
                                    <small class="text-danger">*{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                <label for="photo">Logo de la Empresa</label>
                                <div class="custom-file mb-2">
                                    <input type="file" class="custom-file-input" id="photo" name="photo" value="{{ old('photo') }}" accept="image/*">
                                    <label class="custom-file-label" for="photo">
                                        Tamaño 100×100
                                    </label>
                                    @error('photo')
                                        <small class="text-danger">*{{$message}}</small>
                                    @enderror
                                </div>
                                <div  class="d-flex">
                                    <div id="imagePreview" class="mx-auto">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                <label for="web_site">Sitio Web</label>
                                <input type="text" class="form-control" id="web_site" name="web_site" placeholder="https://www.empresa.com" value="{{ old('web_site') }}">
                                @error('web_site')
                                    <small class="text-danger">*{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xl-12 col-lg-12 col-md-6 col-sm-6">
                                    <button type="submit" class="btn btn-success mb-2 btn-block rounded-pill shadow-hover w-100">
                                        Agregar Empresa
                                    </button>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
@endsection