@extends('layouts.app')

@if(Session::has('success'))
    <div class="alert alert-info">
        {{ Session::get('success') }}
    </div>
@endif

@section('content')<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a class="btn btn-primary" href="{{ URL::to('/createRepo/'.$dossierActuel->id) }}">Ajouter un répertoire</a>
                <a class="btn btn-primary" href="{{ URL::to('/upload/'.$dossierActuel->id) }}">Ajouter un fichier</a>
            </div>
            <div class="panel-body">
                Vos répertoires :
                @foreach($userepo as $repository)
                    @if($repository->dossierPrimaire != 'Y')
                        @if($repository->dossierParent == $dossierActuel->cheminDossier)
                            <br>
                            <a href="{{ URL::to( '/repertoire/'.$repository->id)  }}">{{$repository->name}}</a>
                        @endif
                    @endif
                @endforeach
                <br>
                Vos Fichier :
                @foreach($userFile as $File)
                    @if($File->dossierStockage == $dossierActuel->cheminDossier)
                        <br>
                        <p>{{ $File->name }}</p>
                        <a href="{{ URL::to( '/download/'.$File->name.'/'.$nomDossierActuel)  }}">Télécharger le fichier</a>
                        <a class="btn btn-primary" href="{{ URL::to('/rename/'.$File->id) }}">Renommer le fichier</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="container">

</div>
@endsection
