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
                    <a class="btn btn-primary" href="{{ URL::to('/upload/'.$repo->id.'/'.'Sec') }}">Ajouter un fichier</a>
                </div>
                <div class="panel-body">
                    Dossier : {{$reponame}}
                    @foreach($userepo as $repository)
                        @if($repository->dossierPrimaire != 'Y')
                            @if($repository->dossierParent == $dossierActuel)
                                <br>
                                <a href="{{ URL::to( '/repertoire/'.$repository->id)  }}">{{$repository->name}}</a>
                                <br>
                                <a class="btn btn-primary" href="{{ URL::to('/rename/'.$repository->id.'/'.$repo->id.'/'.'D') }}">Renommer le dossier</a>
                                <a class="btn btn-primary" href="{{ URL::to('/suppress/'.$repository->id.'/'.'D'.'/'.$repo->id.'/'.'Sec') }}">Supprimer le dossier</a>
                                <a class="btn btn-primary" href="{{ URL::to('/downloadRepo/'.$repository->id) }}">Télécharger le dossier</a>
                            @endif
                        @endif
                    @endforeach
                    <br>
                    Fichier :
                    @foreach($userFile as $File)
                        @if($File->dossierStockage == $dossierActuel)
                            <br>
                            <p>{{ $File->name }}</p>
                            <button onclick="launchModal('{{$File->name}}','../{{$File->cheminFichier}}')" data-modal-id="modal-video">{{ $File->name }}</button>
                            <a href="{{ URL::to( '/downloadFile/'.$File->name.'/'.$repo->id)  }}">Télécharger le fichier</a>
                            <a class="btn btn-primary" href="{{ URL::to('/rename/'.$File->id.'/'.$repo->id.'/'.'F') }}">Renommer le fichier</a>
                            <a class="btn btn-primary" href="{{ URL::to('/suppress/'.$File->id.'/'.'F'.'/'.$repo->id.'/'.'Fic') }}">Supprimer le fichier</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL video -->
    <div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="modal-video-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button onclick="closeModal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-video">
                        <div id="MyVidModal" class="embed-responsive embed-responsive-16by9">
                            <video id='myVid' src='' width="568" height="240" controls></video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal image -->
    <div class="modal fade" id="modal-image" tabindex="-1" role="dialog" aria-labelledby="modal-video-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-image">
                        <img id="myImg" width="565" height="565" src="">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection