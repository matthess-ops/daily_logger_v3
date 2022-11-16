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





    {{-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                @can('isClient', App\Testpol::class)
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Activiteiten
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                    href="{{ route('dailyActivity.index', ['user_id' => Auth::id()]) }}">Logger</a>
                                <a class="dropdown-item" href="{{ route('clientActivities.index') }}">Instellingen</a>
                                <a class="dropdown-item" href="">Grafieken</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Dagelijkse rapportage
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                    href="{{ route('dailyQuestion.index', ['user_id' => Auth::id()]) }}">Overzicht</a>
                                <a class="dropdown-item" href="">Grafieken</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Account
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                    href="{{ route('client.show', ['client_id' => Auth::user()->client->id]) }}">Gegevens</a>
                            </div>
                        </li>
                        <li>
                        </li>
                    </ul>
                @endcan

                @can('isAdmin', App\Testpol::class)
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Clienten
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('client.index') }}">Zoeken</a>
                                <a class="dropdown-item" href="{{ route('client.create') }}">Toevoegen</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Begeleiders
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('mentor.index') }}">Zoeken</a>
                                <a class="dropdown-item" href="{{ route('mentor.create') }}">Toevoegen</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Rapportage
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('defaultquestion.edit') }}">config</a>
                            </div>
                        </li>
                    </ul>
                @endcan

                @can('isMentor', App\Testpol::class)
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Clienten
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('client.index') }}">Zoeken</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Rapportages
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('mentor.dailyquestion.index') }}">Open</a>


                            </div>
                        </li>

                    </ul>
                @endcan

                <a class="nav-item nav-link justify-content-end text-light" href="{{ route('logout') }}"
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
    </div> --}}

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">

            <a class="navbar-brand">Brand</a>
            <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="my-nav" class="collapse navbar-collapse">


                @can('isClient', App\Testpol::class)
                    <ul class="navbar-nav mr-auto">
                        {{-- <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle " href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Activiteiten
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                    href="{{ route('dailyActivity.index', ['user_id' => Auth::id()]) }}">Logger</a>
                                <a class="dropdown-item" href="{{ route('clientActivities.index') }}">Instellingen</a>
                                <a class="dropdown-item" href="{{ route('graph.activities', ['user_id' => Auth::id()])  }}">Grafieken</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Dagelijkse rapportage
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                    href="{{ route('dailyQuestion.index', ['user_id' => Auth::id()]) }}">Overzicht</a>
                                    <a class="dropdown-item" href="{{ route('graph.dailyreportsgraph', ['user_id' => Auth::id()])  }}">Grafieken</a>
                                </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Account
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                    href="{{ route('client.show', ['client_id' => Auth::user()->client->id]) }}">Gegevens</a>
                            </div>
                        </li> --}}

                        {{-- new tabs --}}

                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('log.edit', ['user_id' => Auth::id(),'date'=>Carbon\Carbon::today()]) }}">Vandaag </a>
                          </li>



                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Terugkijken
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                
                                
                                <a class="dropdown-item" href="{{ route('log.index', ['user_id' => Auth::id()]) }}">Deze week aanpassen</a>
                                {{-- <a class="dropdown-item" href="{{ route('graph.index', ['user_id' => Auth::id()]) }}">Overzicht</a> --}}
                            </div>

                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Account
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"
                                    href="">Activiteiten aanpassen</a>
                                    <a class="dropdown-item"
                                    href="">Persoonlijke informatie aanpassen</a>
                            </div>

                        </li>

                    </ul>
                @endcan

                @can('isAdmin', App\Testpol::class)
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Clienten
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('client.index') }}">Zoeken</a>
                                <a class="dropdown-item" href="{{ route('client.create') }}">Toevoegen</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Begeleiders
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('mentor.index') }}">Zoeken</a>
                                <a class="dropdown-item" href="{{ route('mentor.create') }}">Toevoegen</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Rapportage
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('defaultquestion.edit') }}">config</a>
                            </div>
                        </li>
                    </ul>
                @endcan


                @can('isMentor', App\Testpol::class)
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Clienten
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('client.index') }}">Zoeken</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Rapportages
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('mentor.dailyquestion.index') }}">Open</a>


                            </div>
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
