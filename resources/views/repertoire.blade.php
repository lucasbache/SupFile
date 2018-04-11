@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @foreach($listeDossier as $dossier)
                        <a class="btn btn-info" href="{{ url('/repertoire') }}"> > {{ $dossier }}</a>
                    @endforeach
                    <a class="btn btn-primary" href="{{ url('/createRepo') }}">Ajouter un répertoire</a>
                    <a class="btn btn-primary" href="{{ url('/upload') }}">Ajouter un fichier</a>
                </div>
                <div class="panel-body">
                    Dossier : {{Session::get('destination')}}
                    @foreach($userepo as $repository)
                        @if($repository->dossierPrimaire != 'Y')
                            @if($repository->dossierParent == Session::get('dossierActuel'))
                                <br>
                                <a class="btn btn-info" onClick="destination({{$repository->name}});">{{ $repository->name }}</a>
                            @endif
                        @endif
                    @endforeach
                    <br>
                    Fichier :
                    @foreach($userFile as $File)
                        @if($File->dossierStockage == Session::get('dossierActuel'))
                            <br>
                            <p>{{ $File->name }}</p>
                            <a href="{{ URL::to( '/download/'.$File->name)  }}" target="_blank">Télécharger le fichier</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection