@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a class="btn btn-primary" href="{{ URL::to('/createRepo/'.$repo->id) }}">Ajouter un répertoire</a>
                        <a class="btn btn-primary" href="{{ URL::to('/upload/'.$repo->id) }}">Ajouter un fichier</a>
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
                                <p>{{ $File->name }}</p>
                                <a href="{{ URL::to( '/download/'.$File->name.'/'.$dossierFichier)  }}">Télécharger le fichier</a>
                            @endif
                        @endforeach
                        <a class="btn btn-primary" href="{{ URL::to('/createRepo/'.$repo->id) }}">Ajouter un répertoire</a>

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createRepo">
                            Launch demo modal
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="createRepo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                                <form method="post" enctype="multipart/form-data">
                                                    <form-group>
                                                        {{ csrf_field() }}
                                                        Nom du dossier
                                                        <br />
                                                        <input type="text" name="name" />
                                                        <input type="hidden" name="path" value="{{$repoPath}}" />
                                                        <input type="Submit" value="Créer" />
                                                    </form-group>
                                                </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Créer</button>
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