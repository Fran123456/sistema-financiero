<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        <!--OTROS-->
        <!-- Font Awesome -->
        <link
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
          rel="stylesheet"
        />
        <!-- Google Fonts -->
        <link
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
          rel="stylesheet"
        />
        <!-- MDB -->
        <link
          href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css"
          rel="stylesheet"
        />
        <script
          type="text/javascript"
          src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"
        ></script>


        @stack('modals')

        @livewireScripts

        @stack('scripts')
        <script
          src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="{!! asset('js/modal.js') !!}"></script>


      <script type="text/javascript">
      $('.modal ').insertAfter($('body'));
      </script>

      <style>
      #sidebar {
        width: 20%;
        height: 100vh;
        background: #343a40;
      }
    </style>
</head>
<body class="font-sans antialiased bg-light">
    <x-jet-banner />
  {{--@livewire('navigation-menu')--}}

    <div class="d-flex">
    <div id="sidebar">
      <div class="p-2">
        <a href="#" class="navbar-brand text-center text-light w-100 p-4 border-bottom">
          SISTEMA ANF115
        </a>
      </div>
      <div id="sidebar-accordion" class="accordion">
        <div class="list-group">

          <a href="{!! route('dashboard') !!}" class="list-group-item list-group-item-action bg-dark text-light">
            <i class="fa fa-shopping-cart mr-3" aria-hidden="true"></i>Dashboard
          </a>

          @can('retrieve_users')
          <a href="#profile-items" data-toggle="collapse" aria-expanded="false"
            class="list-group-item list-group-item-action bg-dark text-light">
            <i class="fa fa-user mr-3" aria-hidden="true"></i>General
          </a>
          <div id="profile-items" class="collapse" data-parent="#sidebar-accordion">
            <a href="{{ route('users') }}" :active="request()->routeIs('users')" class="list-group-item list-group-item-action bg-dark text-light pl-5">
              Usuarios
            </a>
            <a href="{{ route('roles') }}"  :active="request()->routeIs('roles')"   class="list-group-item list-group-item-action bg-dark text-light pl-5">
              Roles
            </a>
          </div>
          @endcan



          <a href="#giro-items" data-toggle="collapse" aria-expanded="false"
            class="list-group-item list-group-item-action bg-dark text-light">
            <i class="fa fa-user mr-3" aria-hidden="true"></i>Empresas y giros
          </a>
          <div id="giro-items" class="collapse" data-parent="#sidebar-accordion">
            <a href="{{ route('bussiness-rotation-index') }}" :active="request()->routeIs('bussiness-rotation-index')" class="list-group-item list-group-item-action bg-dark text-light pl-5">
              Giros empresariales
            </a>

          </div>



        </div>
      </div>
    </div>
    <div class="content w-100">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-xl">
          <a class="navbar-brand" href="#">Container XL</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07XL" aria-controls="navbarsExample07XL" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarsExample07XL">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <section class="p-3">
          <main class="container my-3">
                  {{ $slot }}
          </main>
      </section>
    </div>
  </div>

</body>
</html>
