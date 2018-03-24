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
                <a href="{{ url('/createRepo') }}">Ajouter un répertoire</a>
            </div>
            <div class="panel-body">
                Vos répertoires :
                @foreach($userepo as $repository)
                    @if($repository->dossierPrimaire != 'Y')
                    <br>
                    <input type="button" value="{{ $repository->name }}">
                    <a href="{{ url('/repertoire') }}">{{ $repository->name }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="container">

</div>
@endsection
