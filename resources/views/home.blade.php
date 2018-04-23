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
                </div>
                <div class="panel-body">
                    Vos répertoires :
                    <ul class="list-group">
                        @foreach($userepo as $repository)
                            <li class="list-group-item d-flex justify-content-between align-items-center" >
                                <a href="{{ URL::to( '/repertoire/'.$repository->id)  }}">{{$repository->name}}</a>
                                <span class="badge badge-primary badge-pill">14</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    Vos Dossiers :
                    @foreach($userepo as $repository)
                        @if($repository->dossierPrimaire != 'Y')
                            @if($repository->dossierParent == $dossierActuel->cheminDossier)
                                <br>
                                <a href="{{ URL::to( '/repertoire/'.$repository->id)  }}">{{$repository->name}}</a>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
