@extends('layouts.app')

@if(Session::has('success'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(Session::has('error'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ Session::get('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@section('content')

    <br/>
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
                                            <span class="badge">
                                            <a href="{{ URL::to('/downloadRepo/'.$repository->id) }}">
                                                <i class="material-icons">get_app</i></a>
                                            <a href="{{ URL::to('/rename/'.$repository->id.'/'.$repo->id.'/'.'D') }}">
                                                <i class="material-icons">create</i></a>
                                            <a href="{{ URL::to('/suppress/'.$repository->id.'/'.'D'.'/'.$repo->id.'/'.'Sec') }}">
                                                <i class="material-icons">delete_forever</i></a>
                                            </span>
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
                                        <li class="breadcrumb-item active" aria-current="page"><a
                                                    href="{{ URL::to( '/home' ) }}"> {{ $dossier->name }}</a></li>
                                    @else
                                        @if($dossier->cheminDossier == $dossierActuel)
                                            <li class="breadcrumb-item active"
                                                aria-current="page">{{ $dossier->name }}</li>
                                        @else
                                            <li class="breadcrumb-item"><a
                                                        href="{{ URL::to( '/repertoire/'.$dossier->id) }}"> {{ $dossier->name }}</a>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            </ol>
                        </nav>
                        <h3>Vos fichiers :</h3>
                        <div class="card-deck">
                            @foreach($userFile as $File)
                                @if($File->dossierStockage == $dossierActuel)
                                    <div class="col-md-4">
                                        <div class="card border-primary mb-3" style="width: 15rem;">
                                            <div class="card-header">
                                                <a href="{{ URL::to( '/downloadFile/'.$File->id)  }}">
                                                    <i class="material-icons">get_app</i>
                                                </a>
                                                <a href="{{ URL::to('/rename/'.$File->id.'/'.$repo->id.'/'.'F') }}">
                                                    <i class="material-icons">create</i>
                                                </a>
                                                <a href="{{ URL::to('/suppress/'.$File->id.'/'.'F'.'/'.$repo->id.'/'.$repo->dossierParent) }}">
                                                    <i class="material-icons">delete_forever</i>
                                                </a>
                                            </div>
                                            <div class="card-body text-primary">
                                                <h4 class="card-title">{{$File->name}}</h4>
                                                <br>
                                                @if($File->extension == 'jpg'
                                                    or $File->extension == 'jpeg'
                                                    or $File->extension == 'png'
                                                    or $File->extension == 'txt'
                                                    or $File->extension == 'mp4'
                                                    or $File->extension == 'docx')
                                                    <button onclick="launchModal('{{$File->name}}','../public/{{$File->cheminFichier}}')" data-modal-id="modal-video" class="btn btn-primary">Preview</button>
                                                @endif
                                            </div>
                                            <div class="card-footer">
                                                <small class="text-muted">Last update on {{$File->updated_at}}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Modal File Upload -->
                    <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                            <br/>
                                            <input type="file" name="photos[]"
                                                   accept="file_extension|video/mp4|image/*|media_type"/>
                                            <input type="hidden" name="path" value="{{$repoPath}}"/>
                                            <input type="hidden" name="id" value="{{$repo->id}}"/>
                                            <input type="hidden" name="typeDoss" value="{{$repo->dossierParent}}"/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <input type="submit" class="btn btn-primary" name="uploadFileButton"
                                                   value="Créer" id="uploadFileButton">
                                        </div>
                                    </form-group>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Folder Creation -->
                    <div class="modal fade" id="createRepo" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                            <br/>
                                            <input type="text" name="name">
                                            <input type="hidden" name="path" value="{{$repoPath}}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <input type="submit" class="btn btn-primary" name="createRepoButton"
                                                   value="Créer" id="createRepoButton">
                                        </div>
                                    </form-group>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL video -->
                    <div class="modal fade" id="modal-video" tabindex="-1" role="dialog"
                         aria-labelledby="modal-video-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button onclick="closeModal()" type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
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
                    <div class="modal fade" id="modal-image" tabindex="-1" role="dialog"
                         aria-labelledby="modal-video-label">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-image">
                                        <img id="myImg" width="100%" height="auto" src="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- The Modal doc -->
                    <div class="modal fade" id="modal-doc" tabindex="-1" role="dialog"
                         aria-labelledby="modal-video-label">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-doc">
                                        <p id="myDoc">
                                        {{$content = File::get($File->cheminFichier)}}
                                        </p>
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