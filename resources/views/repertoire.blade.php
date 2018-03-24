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
                    Dossier : {{Session::get('destination')}}
                    @foreach($userepo as $repository)
                        @if($repository->dossierPrimaire != 'Y')
                            @if($repository->dossierParent == Session::get('dossierActuel'))
                                <br>
                                <a href="{{ url('/repertoire') }}">{{ $repository->name }}</a>
                                {{ Session::put('destination',$repository->name) }}
                            @endif
                        @endif
                    @endforeach
                    <br>
                    Fichier :
                    @foreach($userFile as $File)
                        @if($File->dossierStockage == Session::get('dossierActuel'))
                            <br>
                            <p>{{ $File->name }}</p>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection