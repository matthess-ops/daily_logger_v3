<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>



    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">

            <a class="navbar-brand">Acti</a>
            <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="my-nav" class="collapse navbar-collapse">


                @can('isClient')
                    <ul class="navbar-nav mr-auto">


                        <li class="nav-item {{ Route::is('log.edit') ? 'active' : '' }}
                        ">
                            <a class="nav-link" href="{{ route('log.edit', ['user_id' => Auth::id(),'date'=>Carbon\Carbon::today()]) }}">Vandaag </a>
                          </li>



                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Route::is('graph.index') ? 'active' : '' }} {{ Route::is('log.index') ? 'active' : '' }}" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Terugkijken
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                                <a class="dropdown-item" href="{{ route('log.index', ['user_id' => Auth::id()]) }}">Deze week aanpassen</a>
                                <a class="dropdown-item" href="{{ route('graph.index', ['user_id' => Auth::id()]) }}">Overzicht</a>
                            </div>

                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle{{ Route::is('client.show') ? 'active' : '' }} {{ Route::is('clientActivities.index') ? 'active' : '' }}" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Account
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                    href="{{route('clientActivities.index')}}">Activiteiten aanpassen</a>
                                    <a class="dropdown-item"
                                    href="{{route('client.show',['client_id'=>Auth::id()])}}">Persoonlijke informatie aanpassen</a>
                            </div>

                        </li>

                    </ul>
                @endcan

                @can('isMentor')
                <ul class="navbar-nav mr-auto">


                    <li class="nav-item {{ Route::is('client.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('client.index') }}">Clienten </a>
                      </li>


                      <li class="nav-item {{ Route::is('mentor.dailyquestion.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('mentor.dailyquestion.index')  }}">Rapportages </a>
                      </li>


                </ul>
            @endcan

                @can('isAdmin')
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle {{ Route::is('client.create') ? 'active' : '' }} {{ Route::is('client.index') ? 'active' : '' }}" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Clienten
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('client.index') }}">Zoeken</a>
                                <a class="dropdown-item" href="{{ route('client.create') }}">Toevoegen</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Route::is('mentor.create') ? 'active' : '' }} {{ Route::is('mentor.index') ? 'active' : '' }}" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Begeleiders
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('mentor.index') }}">Zoeken</a>
                                <a class="dropdown-item" href="{{ route('mentor.create') }}">Toevoegen</a>
                            </div>
                        </li>

                        <li class="nav-item {{ Route::is('defaultquestion.edit') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('defaultquestion.edit') }}">Standaard vragen </a>
                          </li>


                    </ul>
                @endcan



                <a class="nav-item nav-link text-light" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

    </nav>

    <div class="container">
        <main class="py-4">
            @yield('content')
        </main>
    </div>

</body>

</html>
