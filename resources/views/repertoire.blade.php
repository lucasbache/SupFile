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
            <div class="col-md-4 side-repo fixed">
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
                                            <a href="{{ URL::to( '/repertoire/'.$repository->id)  }}">
                                                {{$repository->name}}
                                            </a>
                                            <span class="badge">
                                            <a href="{{ URL::to('/downloadRepo/'.$repository->id) }}">
                                                <i class="material-icons">get_app</i>
                                            </a>
                                            <a href="" data-toggle="modal" data-target="#renameRepo" data-id="{{$repository->id}}" class="open-modal">
                                                <i class="material-icons">create</i>
                                            </a>
                                            <a href="{{ URL::to('/suppress/'.$repository->id.'/'.'D'.'/'.$repo->id.'/'.'Sec') }}">
                                                <i class="material-icons">delete_forever</i>
                                            </a>
                                            <a href="" data-toggle="modal" data-target="#publicLink" class="open-modal-publicLink" data-id="{{$repository->publicLink}}">
                                                <i class="material-icons">link</i>
                                            </a>
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
                                        <div class="card features homecard mb-3" style="width: 15rem;">
                                            <div class="card-header" data-toggle="collapse" data-target="#{{$File->name}}" aria-expanded="false" aria-controls="cardCollapse">
                                                <h4 class="card-title">{{$File->name}}</h4>

                                            </div>
                                            <div class="card-body text-primary" id="{{$File->name}}">
                                                <a href="{{ URL::to( '/downloadFile/'.$File->id)  }}" title="Télécharger">
                                                    <i class="material-icons">get_app</i>
                                                </a>
                                                <a href="" data-toggle="modal" data-target="#renameFile" class="open-modal" data-id="{{$File->id}}" title="Modifier">
                                                    <i class="material-icons">create</i>
                                                </a>
                                                <a href="{{ URL::to('/suppress/'.$File->id.'/'.'F'.'/'.$repo->id.'/'.$repo->dossierParent) }}" title="Supprimer">
                                                    <i class="material-icons">delete_forever</i>
                                                </a>
                                                <a href="" data-toggle="modal" data-target="#publicLink" class="open-modal-publicLink" data-id="{{$File->publicLink}}" title="Partager">
                                                    <i class="material-icons">link</i>
                                                </a>
                                                @if($File->extension == 'jpg'
                                                    or $File->extension == 'jpeg'
                                                    or $File->extension == 'png'
                                                    or $File->extension == 'txt'
                                                    or $File->extension == 'mp4'
                                                    or $File->extension == 'docx')
                                                <a href="" onclick="launchModal('{{$File->name}}','../public/{{$File->cheminFichier}}')" data-modal-id="modal-video" class="open-modal" title="Aperçu">
                                                    <i class="material-icons">launch</i>
                                                </a>
                                                @endif
                                            </div>
                                            <div class="card-footer cardCollapse">
                                                <small class="text-muted">Last update on {{$File->updated_at}}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
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
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Importer un fichier</h5>
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
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler
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
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Créer un dossier</h5>
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
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler
                                            </button>
                                            <input type="submit" class="btn btn-primary" name="createRepoButton"
                                                   value="Créer" id="createRepoButton">
                                        </div>
                                    </form-group>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal rename Folder  -->
                    <div class="modal fade" id="renameRepo" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data">
                                    <form-group>
                                        {{ csrf_field() }}
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Renommer</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Nom du dossier
                                            <br/>
                                            <input type="text" name="name"/>
                                            <input type="hidden" name="eventId" id="eventId"/>
                                            <input type="hidden" name="idDoss" value="{{$repo->id}}"/>
                                            <input type="hidden" name="objectType" value="D"/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler
                                            </button>
                                            <input type="submit" class="btn btn-primary" value="Créer">
                                        </div>
                                    </form-group>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal rename File  -->
                    <div class="modal fade" id="renameFile" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form method="post" enctype="multipart/form-data">
                                    <form-group>
                                        {{ csrf_field() }}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Renommer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Nom du fichier
                                            <br/>
                                            <input type="text" name="name" />
                                            <input type="hidden" name="eventId" id="eventId" />
                                            <input type="hidden" name="idDoss" value="{{$repo->id}}" />
                                            <input type="hidden" name="objectType" value="F" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler
                                            </button>
                                            <input type="submit" class="btn btn-primary" value="Créer">
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
                                        <p id="myDoc" >

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- The Modal public link -->
                    <div class="modal fade" id="publicLink" tabindex="-1" role="dialog"
                         aria-labelledby="modal-video-label">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Lien public</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" aria-describedby="basic-addon2" name="publicLinkButton" id="publicLinkButton" />
                                        <div class="input-group-append">
                                            <button onclick="copyClipboard()" class="btn btn-outline-secondary" value="" type="button">Copier le lien</button>
                                        </div>
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