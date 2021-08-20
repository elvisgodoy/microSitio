@extends('layouts.dashboard_app')

@section('content')
    @section('welcome')
        <p class="lead text-muted">Dashboard/Perfil de Ususario</p>
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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex p-0">
                    <h5 class="mx-3 my-auto">Datos Generales</h5>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item">
                            <a 
                                @if(Session::has('update'))
                                    class="nav-link" 
                                @else
                                    class="nav-link active" 
                                @endif 
                                href="#menu1" data-toggle="tab">Datos</a>
                        </li>
                        <li class="nav-item">
                            <a 
                                @if(Session::has('update'))
                                    class="nav-link active" 
                                @else
                                    class="nav-link" 
                                @endif 
                                href="#menu2" data-toggle="tab">Actualizar Datos</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div 
                            @if(Session::has('update'))
                                class="tab-pane" 
                            @else
                                class="tab-pane active" 
                            @endif 
                            role="tabpanel" id="menu1">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                    <div  class="d-flex">
                                        <div class="mx-auto">
                                            @if (Auth::user()->photo != null)
                                                <img src="{{ Storage::url(Auth::user()->photo)  }}" alt="Imagen de perfil" class="img-fluid rounded-circle mr-2" with="100">
                                            @else 
                                                <img src="{{ Storage::url('user.jpg') }}" alt="Imagen de perfil" class="img-fluid rounded-circle mr-2" width="100">
                                            @endif
                                        </div>
                                    </div>                                        
                                </div>
                                
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                                    <div class="row">
                                        <div class="form-group col-xl-6 col-lg-6 col-md-12">
                                            <label>Nombre</label>
                                            <h4 class="font-weight-bold">{{ Auth::user()->name }}</h4>
                                        </div>
                                        
                                        <div class="form-group col-xl-6 col-lg-6 col-md-12">
                                            <label>Apellido</label>
                                            <h4 class="font-weight-bold">{{ Auth::user()->last_name }}</h4>
                                        </div>
        
                                        <div class="form-group col-xl-6 col-lg-6 col-md-12">
                                            <label>Correo Electronico</label>
                                            <h4 class="font-weight-bold">{{ Auth::user()->email }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div 
                            @if(Session::has('update'))
                                class="tab-pane active" 
                            @else
                                class="tab-pane" 
                            @endif
                            role="tabpanel" id="menu2">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                    <div  class="d-flex">
                                        <div id="imagePreview" class="mx-auto">
                                            @if (Auth::user()->photo != null)
                                                <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Imagen de perfil" class="img-fluid mr-2" width="100">
                                            @else 
                                                <img src="{{ Storage::url('user.jpg') }}" alt="Imagen de perfil" class="img-fluid mr-2" width="100">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                                    <form id="form-data" method="POST" action="{{ url('/user/edit/'. Auth::user()->id) }}" enctype="multipart/form-data"> 
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-xl-6 col-lg-6 col-md-12">
                                                <label for="name">Nombre</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="{{ old('name',Auth::user()->name) }}">
                                                @error('name')
                                                    <small class="text-danger mt-0 pt-0">*{{$message}}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group col-xl-6 col-lg-6 col-md-12">
                                                <label for="last_name">Apellidos</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellido" value="{{ old('last_name',Auth::user()->last_name) }}">
                                                @error('last_name')
                                                    <small class="text-danger mt-0 pt-0">*{{$message}}</small>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-xl-6 col-lg-6 col-md-12">
                                                <label for="email">Correo Electronico</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Correo electronico" value="{{ old('email',Auth::user()->email) }}">
                                                @error('email')
                                                    <small class="text-danger mt-0 pt-0">*{{$message}}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group col-xl-6 col-lg-6 col-md-12">
                                                <label for="file">Seleccione una Foto de Perfil</label>
                                                <div class="custom-file ">
                                                    <input type="file" class="custom-file-input" id="photo" name="photo" placeholder="C:descargas/img.jpg" value="{{ old('photo') }}" accept="image/*">
                                                    <label class="custom-file-label" for="url">Buscar</label>
                                                    @error('photo')
                                                        <small class="text-danger">*{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group col-xl-6 col-lg-6 col-md-12">
                                                <input type="submit" class="btn btn-primary btn-block rounded-pill shadow-hover w-100" value="Actualizar Información">
                                            </div>
                                        </div>
                                    </form> 
                                </div> 
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="modal_delete" ></section>
@endsection 