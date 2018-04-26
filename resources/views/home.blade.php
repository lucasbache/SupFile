@extends('layouts.app')

@if(Session::has('success'))
    <div class="alert alert-info">
        {{ Session::get('success') }}
    </div>
@endif

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="btn btn-primary" href="{{ URL::to('/createRepo/'.$dossierActuel->id) }}">Ajouter un répertoire</a>
                    <a class="btn btn-primary" href="{{ URL::to('/upload/'.$dossierActuel->id) }}">Ajouter un fichier</a>
                </div>
                <div class="panel-body">
                    Vos répertoires :
                    <ul class="list-group">
                        @foreach($userepo as $repository)
                            @if($repository->dossierPrimaire != 'Y')
                                @if($repository->dossierParent == $dossierActuel->cheminDossier)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ URL::to( '/repertoire/'.$repository->id)  }}">{{$repository->name}}</a>
                                        <span class="badge badge-primary badge-pill">14</span>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                    Vos Fichier :
                    @foreach($userFile as $File)
                        @if($File->dossierStockage == $dossierActuel->cheminDossier)
                            <br>
                            <p>{{ $File->name }}</p>
                            <a href="{{ URL::to( '/download/'.$File->name.'/'.$nomDossierActuel)  }}">Télécharger le fichier</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Vos Dossiers :</h3>
                    <div class="card-deck">
                        @foreach($userepo as $repository)
                            @if($repository->dossierPrimaire != 'Y')
                                @if($repository->dossierParent == $dossierActuel->cheminDossier)
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <h4 class="card-title">{{$repository->name}}</h4>
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                            <a href="{{ URL::to( '/repertoire/'.$repository->id)  }}" class="btn btn-primary">{{$repository->name}}</a>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
