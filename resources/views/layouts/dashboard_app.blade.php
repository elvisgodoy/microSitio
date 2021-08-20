<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body> 
    <div id="content-wrapper" class="d-flex" >
        @php
            $ruta = Route::currentRouteName();
        @endphp
        <div id="sidebar-container" class="bg-light border-right toggled">
            <div class="logo">
                <h4 class="font-weight-bold mb-3">
                    <a class="text-dark" href="#">MicroSitio</a>
                </h4> 
            </div>
            <div class="menu list-group-flush">
                <a href="{{ url('/dashboard') }}"
                    @if ('dashboard' == $ruta) 
                        class="active list-group-item list-group-item-action bg-light pt-3 borderd-0" 
                    @else 
                        class="list-group-item list-group-item-action bg-light pt-3 borderd-0" 
                    @endif >
                    <i class="fas fa-table mr-2 lead"></i>Dashboard
                </a>
                <a href="{{ url('/empresas') }}"
                    @if ('empresas.show' == $ruta  || 'empresas' == $ruta) 
                        class="active list-group-item list-group-item-action bg-light pt-3 borderd-0" 
                    @else 
                        class="list-group-item list-group-item-action bg-light pt-3 borderd-0" 
                    @endif >
                    <i class="fas fa-city mr-2 lead"></i>Empresas
                </a>
                <a href="{{ url('/colaboradores') }}" 
                    @if ('colaboradores.show' == $ruta  || 'colaboradores' == $ruta) 
                        class="active list-group-item list-group-item-action bg-light pt-3 borderd-0" 
                    @else 
                        class="list-group-item list-group-item-action bg-light pt-3 borderd-0" 
                    @endif >
                    <i class="fas fa-people-carry mr-2 lead"></i></i>Colaboradores
                </a>
   
                <a href="{{ url('/usuarios') }}" 
                    @if ('usuarios' == $ruta || 'usuarios.show' == $ruta) 
                        class="active list-group-item list-group-item-action bg-light pt-3 borderd-0" 
                    @else 
                        class="list-group-item list-group-item-action bg-light pt-3 borderd-0" 
                    @endif >
                    <i class="fas fa-users mr-2 lead"></i>Usuarios
                </a>
            </div>
               
        </div>
        <div id="page-container" class="w-100 bg-light-blue">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container">
                    <button id="menu-toggle" class="btn btn-light">
                        <i class="fas fa-lg fa-bars"></i>    
                    </button>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse row justify-content-end" id="navbarSupportedContent">
                        <div class="col-4" id="profile">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item dropdown col">
                                    <a class="nav-link dropdown-toggle mr-4" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @if (Auth::user()->photo != null)
                                            <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Imagen de perfil" class="img-fluid rounded-circle mr-2 avatar">
                                        @else
                                            <img src="{{ Storage::url('user.jpg') }}" alt="Imagen de perfil" class="img-fluid rounded-circle mr-2 avatar">
                                        @endif
                                        {{ auth()->user()->name }}
                                    </a>
                                    <div class="dropdown-menu" style="position: absolute;" aria-labelledby="navbarDropdown">
                                        <a  @if ('user_profile.index' == $ruta ) 
                                                class="active dropdown-item" 
                                            @else 
                                                class="dropdown-item" 
                                            @endif
                                            href="{{ url('/user') }}">Perfil
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ url('/logout') }}">Cerrar Sesión</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </nav>

            <div id="content" class="container-fluid">
                <section class="py-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6">
                                @yield('welcome') 
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                @yield('message') 
                            </div>
                        </div>
                    </div>
                </section>
                @yield('content')
            </div>
        </div>
    </div>
    <section id="modalDelete" ></section>
    <!-- Modal para mostrar informacion -->
    <section>
        <div class="modal" id="modalInfo" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-gray">
                        <h5 class="modal-title">Datos de la Empresa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mx-3"> 
                            <div class="form-group col-lg-12">
                                <h6>Nombre de la empresa</h6>
                                <label class="font-weight-bold ml-2" for="" id="empresa"></label>
                            </div>
                            <div class="form-group col-lg-6">
                                <h6>Correo Electronicio</h6>
                                <label class="font-weight-bold ml-2" for="" id="correo"></label>
                            </div>
                            <div class="form-group col-lg-6">
                                <h6>Sitio Web</h6>
                                <a id="ruta" href="" target="_blank">
                                    <label class="font-weight-bold ml-2" for="" id="sitio"></label>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Agregar una nueva empresa-->
    <section>
        <div class="modal fade" id="addNewCompanies">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-gray">
                        <h4 class="modal-title">
                            Nueva Empresa
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="new_companies" id="new_companies" placeholder="Nombre de la Empresa" maxlength="50">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between bg-gray-light">
                        <div class="float-right justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="return add_new_type('#company_id',new_companies,'{{ route('empresas.insertCompany') }}','#addNewCompanies');">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    {{-- cerrar alertas --}}
    <script src="{{ asset('js/closeAlert.js') }}"></script>
    {{-- funcionalidades --}}
    <script src="{{ asset('js/functionalities.js') }}"></script>
</body>
</html>