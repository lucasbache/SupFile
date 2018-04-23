@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @foreach($listeDossier as $dossier)
                        @if($dossier->dossierPrimaire == 'Y')
                            <a class="btn btn-info" href="{{ URL::to( '/home' ) }}"> {{ $dossier->name }}</a>
                        @else
                            <a class="btn btn-info" href="{{ URL::to( '/repertoire/'.$dossier->id) }}"> {{ $dossier->name }}</a>
                        @endif
                    @endforeach
                    <a class="btn btn-primary" href="{{ URL::to('/createRepo/'.$repo->id) }}">Ajouter un répertoire</a>
                    <a class="btn btn-primary" href="{{ URL::to('/upload/'.$repo->id) }}">Ajouter un fichier</a>
                </div>
                <div class="panel-body">
                    Dossier : {{$reponame}}
                    @foreach($userepo as $repository)
                        @if($repository->dossierPrimaire != 'Y')
                            @if($repository->dossierParent == $dossierActuel)
                                <br>
                                <a href="{{ URL::to( '/repertoire/'.$repository->id)  }}">{{$repository->name}}</a>
                            @endif
                        @endif
                    @endforeach
                    <br>
                    Fichier :
                    @foreach($userFile as $File)
                        @if($File->dossierStockage == $dossierActuel)
                            <br>
                            <p>{{ $File->name }}</p>
                            <a href="{{ URL::to( '/download/'.$File->name.'/'.$dossierFichier)  }}">Télécharger le fichier</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection