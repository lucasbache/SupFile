@extends('layouts.app')

@if(Session::has('success'))
    <div class="alert alert-info">
        {{ Session::get('success') }}
    </div>
@endif

@if(Session::has('error'))
    <div class="alert alert-info">
        {{ Session::get('error') }}
    </div>
@endif

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createRepo">
                            Ajouter un répertoire
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadFile">
                            Ajouter un fichier
                        </button>
                    </div>
                    <div class="panel-body">
                        Vos répertoires :
                        <ul class="list-group">
                            @foreach($userepo as $repository)
                                @if($repository->dossierPrimaire != 'Y')
                                    @if($repository->dossierParent == $dossierActuel)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a href="{{ URL::to( '/repertoire/'.$repository->id)  }}">{{$repository->name}}</a>
                                            <span class="badge badge-primary badge-pill">14</span>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @foreach($listeDossier as $dossier)
                                    @if($dossier->dossierPrimaire == 'Y')
                                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ URL::to( '/home' ) }}"> {{ $dossier->name }}</a></li>
                                    @else
                                        @if($dossier->cheminDossier == $dossierActuel)
                                            <li class="breadcrumb-item active" aria-current="page">{{ $dossier->name }}</li>
                                        @else
                                            <li class="breadcrumb-item"><a href="{{ URL::to( '/repertoire/'.$dossier->id) }}"> {{ $dossier->name }}</a></li>
                                        @endif
                                    @endif
                                @endforeach
                            </ol>
                        </nav>
                        <h3>Vos Dossiers :</h3>
                        <div class="row">
                            <div class="card-deck">
                                @foreach($userepo as $repository)
                                    @if($repository->dossierPrimaire != 'Y')
                                        @if($repository->dossierParent == $dossierActuel)
                                            <div class="col-md-4">
                                                <div class="card" style="width: 18rem;">
                                                    <!--<img class="card-img-top" src="../public/Images/folder-icon.jpg" alt="teszt">-->
                                                    <div class="card-body">
                                                        <h4 class="card-title">{{$repository->name}}</h4>
                                                        <a href="{{ URL::to( '/repertoire/'.$repository->id)  }}" class="btn btn-primary">Go to Folder</a>
                                                        <a class="btn btn-primary" href="{{ URL::to('/downloadRepo/'.$repository->id) }}">Télécharger le dossier</a>
                                                        <a class="btn btn-primary" href="{{ URL::to('/rename/'.$repository->id.'/'.$repo->id.'/'.'D') }}">Renommer le dossier</a>
                                                        <a class="btn btn-primary" href="{{ URL::to('/suppress/'.$repository->id.'/'.'D'.'/'.$repo->id.'/'.'Sec') }}">Supprimer le dossier</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <h3>Vos Fichier :</h3>
                        @foreach($userFile as $File)
                            @if($File->dossierStockage == $dossierActuel)
                                <br>
                                <button onclick="launchModal('{{$File->name}}','../public/{{$File->cheminFichier}}')" data-modal-id="modal-video">{{ $File->name }}</button>
                                <a href="{{ URL::to( '/downloadFile/'.$File->id)  }}">Télécharger le fichier</a>
                                <a class="btn btn-primary" href="{{ URL::to('/rename/'.$File->id.'/'.$repo->id.'/'.'F') }}">Renommer le fichier</a>
                                <a class="btn btn-primary" href="{{ URL::to('/suppress/'.$File->id.'/'.'F'.'/'.$repo->id.'/'.'Fic') }}">Supprimer le fichier</a>
                            @endif
                        @endforeach
                    </div>

                    <!-- Modal File Upload -->
                    <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data">
                                    <form-group>
                                        {{ csrf_field() }}
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Séléctionner votre fichier:
                                            <br />
                                            <input type="file" name="photos[]" accept="file_extension|video/mp4|image/*|media_type"/>
                                            <input type="hidden" name="path" value="{{$repoPath}}" />
                                            <input type="hidden" name="id" value="{{$repo->id}}" />
                                            <input type="hidden" name="typeDoss" value="{{'Sec'}}" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-primary" name="uploadFileButton" value="Créer" id="uploadFileButton">
                                        </div>
                                    </form-group>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Folder Creation -->
                    <div class="modal fade" id="createRepo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data">
                                    <form-group>
                                        {{ csrf_field() }}
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Nom du dossier
                                            <br />
                                            <input type="text" name="name">
                                            <input type="hidden" name="path" value="{{$repoPath}}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-primary" name="createRepoButton" value="Créer" id="createRepoButton">
                                        </div>
                                    </form-group>
                                </form>
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
                </div>
            </div>
        </div>
    </div>

@endsection