<!DOCTYPE html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
      integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<html lang="{{ app()->getLocale() }}">

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Supfile</title>

    <!-- Styles -->

    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg fixed-top row">
        <div class="container nav-cont col-md-12">
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ URL::to( '/home' ) }}" id="lien-logo">
                <img id="logo" class="" src="{{ asset('Images/supcloud.png') }}" height="50" alt="SupFile">
            </a>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                    <form class="form-inline">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" placeholder="Rechercher..." aria-label="Search"
                                   aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" style="margin-right: 20%;" type="button">Go
                                </button>
                            </div>
                        </div>
                    </form>
                    @guest
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav">
                                <a href="{{ route('login') }}" class="nav-link">Se connecter</a>
                                <a href="{{ route('register') }}" class="nav-link">S'inscrire</a>
                            </div>
                        </div>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{ url('/profil') }}">Votre profil</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Déconnexion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                            @endguest
                        </li>
                </ul>

            </div>
        </div>
        <div class="dividline light-grey"></div>
    </nav>

<div id="containerSite">
    <div style="margin-top: 6%;">
        @yield('content')
    </div>
    <footer class="page-footer font-small fixed-bottom" id="footer">
        <div class="text-center text-md-left">
            <div class="row">
                <div class="col-md-4">
                    <img id="logo" class="d-inline-block mr-1" src="{{ asset('Images/supcloud.png') }}" height="30" alt="SupFile">
                    <p>© 2018 Copyright
                        <a href="/howto">SupFile</a>
                    </p>
                </div>
                <hr class="">
                <div class="col-md-4">
                    <h5 class="text-uppercase h5">L'entreprise</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="/contact">Contact</a>
                        </li>
                        <li>
                            <a href="/howto">Comment faire ?</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="text-uppercase h5">Mentions légales</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="/legal">Mentions légales</a>
                        </li>
                        <li>
                            <a href="/rgpd">Utilisation des données</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>
</div>




<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<!-- <script src="{{ asset('js/app.js') }}"></script> -->
<script src="{{ asset('js/functions.js') }}"></script>
<script src=" {{ asset('js/dropzone.js') }}"></script>
<script src=" {{ asset('js/dropzone-config.js') }}"></script>
</body>

</html>
