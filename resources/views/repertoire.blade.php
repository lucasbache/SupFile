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
                                            <a href="" data-toggle="modal" data-target="#renameRepo"
                                               data-id="{{$repository->id}}" class="open-modal">
                                                <i class="material-icons">create</i>
                                            </a>
                                            <a href="{{ URL::to('/suppress/'.$repository->id.'/'.'D'.'/'.$repo->id.'/'.'Sec') }}">
                                                <i class="material-icons">delete_forever</i>
                                            </a>
                                            <a href="" data-toggle="modal" data-target="#publicLink"
                                               class="open-modal-publicLink" data-id="{{$repository->publicLink}}">
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

                        <form method="post" action="{{ url('/images-save') }}" enctype="multipart/form-data"
                              class="dropzone" id="my-dropzone">
                            {{ csrf_field() }}
                            <div class="card-deck">
                                @foreach($userFile as $File)
                                    @if($File->dossierStockage == $dossierActuel)
                                        <div class="col-md-4">
                                            <div class="card border-primary mb-3" style="width: 15rem;">
                                                <div class="card-header" data-toggle="collapse"
                                                     data-target="#{{$File->id}}" aria-expanded="false"
                                                     aria-controls="cardCollapse">
                                                    <h4 class="card-title">{{$File->name}}</h4>
                                                </div>
                                                <div class="collapse" id="{{$File->id}}">
                                                    <div class="card-body text-primary">
                                                        <a href="{{ URL::to( '/downloadFile/'.$File->id)  }}">
                                                            <i class="material-icons">get_app</i>
                                                        </a>
                                                        <a href="" data-toggle="modal" data-target="#renameFile"
                                                           class="open-modal" data-id="{{$File->id}}">
                                                            <i class="material-icons">create</i>
                                                        </a>
                                                        <a href="{{ URL::to('/suppress/'.$File->id.'/'.'F'.'/'.$repo->id.'/'.$repo->dossierParent) }}">
                                                            <i class="material-icons">delete_forever</i>
                                                        </a>
                                                        <a href="" data-toggle="modal" data-target="#publicLink"
                                                           class="open-modal-publicLink"
                                                           data-id="{{$File->publicLink}}">
                                                            <i class="material-icons">link</i>
                                                        </a>
                                                        @if($File->extension == 'jpg'
                                                            or $File->extension == 'jpeg'
                                                            or $File->extension == 'png'
                                                            or $File->extension == 'mp4'
                                                            or $File->extension == 'PNG'
                                                            or $File->extension == 'JPEG'
                                                            or $File->extension == 'JPG'
                                                            or $File->extension == 'MP4')
                                                            <a href=""
                                                               onclick="launchModal('{{$File->name}}','../public/{{$File->cheminFichier}}')"
                                                               data-modal-id="modal-video" class="open-modal"
                                                               title="Aperçu">
                                                                <i class="material-icons">launch</i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <div class="card-footer">
                                                        <small class="text-muted">Last update
                                                            on {{$File->updated_at}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="dz-message">
                                <div class="col-xs-8">
                                    <div class="message">
                                        <p>Drop files here</p>
                                        <input type="hidden" name="path" value="{{$repoPath}}"/>
                                        <input type="hidden" name="id" value="{{$repo->id}}"/>
                                        <input type="hidden" name="typeDoss" value="{{$repo->dossierParent}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="fallback">
                                <input type="file" name="file" multiple>
                            </div>
                        </form>
                        {{--Dropzone Preview Template--}}
                        <div id="preview" style="display: none;">

                            <div class="dz-preview dz-file-preview">
                                <div class="dz-image"><img data-dz-thumbnail/></div>

                                <div class="dz-details">
                                    <div class="dz-size"><span data-dz-size></span></div>
                                    <div class="dz-filename"><span data-dz-name></span></div>
                                </div>
                                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span>
                                </div>
                                <div class="dz-error-message"><span data-dz-errormessage></span></div>


                                <div class="dz-success-mark">

                                    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1"
                                         xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                        <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                        <title>Check</title>
                                        <desc>Created with Sketch.</desc>
                                        <defs></defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                           fill-rule="evenodd" sketch:type="MSPage">
                                            <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                                  id="Oval-2" stroke-opacity="0.198794158" stroke="#747474"
                                                  fill-opacity="0.816519475" fill="#FFFFFF"
                                                  sketch:type="MSShapeGroup"></path>
                                        </g>
                                    </svg>

                                </div>
                                <div class="dz-error-mark">
                                    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1"
                                         xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                        <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                        <title>error</title>
                                        <desc>Created with Sketch.</desc>
                                        <defs></defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                           fill-rule="evenodd" sketch:type="MSPage">
                                            <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474"
                                               stroke-opacity="0.198794158" fill="#FFFFFF"
                                               fill-opacity="0.816519475">
                                                <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                                      id="Oval-2" sketch:type="MSShapeGroup"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        {{--End of Dropzone Preview Template--}}
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
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Annuler
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
                                    <input type="text" class="form-control" placeholder="Nom du dossier" name="name">
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
                                    <input type="text" class="form-control" placeholder="Nom du dossier" name="name">
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
                                    <input type="text" class="form-control" placeholder="Nom du fichier" name="name">
                                    <input type="hidden" name="eventId" id="eventId"/>
                                    <input type="hidden" name="idDoss" value="{{$repo->id}}"/>
                                    <input type="hidden" name="objectType" value="F"/>
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Preview de votre vidéo</h5>
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Preview de votre image</h5>
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Preview document</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-doc">
                                <p id="myDoc">

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
                                <input type="text" class="form-control" aria-describedby="basic-addon2"
                                       name="publicLinkButton" id="publicLinkButton"/>
                                <div class="input-group-append">
                                    <button onclick="copyClipboard()" class="btn btn-outline-secondary" value=""
                                            type="button">Copier le lien
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection