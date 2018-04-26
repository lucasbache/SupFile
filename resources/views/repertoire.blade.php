@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @foreach($listeDossier as $dossier)
                                @if($dossier->dossierPrimaire == 'Y')
                                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ URL::to( '/home' ) }}"> {{ $dossier->name }}</a></li>
                                @else
                                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ URL::to( '/repertoire/'.$dossier->id) }}"> {{ $dossier->name }}</a></li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>

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