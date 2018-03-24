@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ url('/createRepo') }}">Ajouter un répertoire</a>
                    <a href="{{ url('/upload') }}">Ajouter un fichier</a>
                </div>
                <div class="panel-body">
                    Vos fichiers :

                </div>
            </div>
        </div>
    </div>

@endsection