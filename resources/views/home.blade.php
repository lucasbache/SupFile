@extends('layouts.app')

@if(Session::has('success'))
    <div class="alert alert-info">
        {{ Session::get('success') }}
    </div>
@endif

<script type="text/javascript">
    function destination(repoDestination){
        Session["destination"]=repoDestination;
        console.log("Test");
        window.location = '/repertoire'
    }
</script>

@section('content')<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a class="btn btn-primary" href="{{ url('/createRepo') }}">Ajouter un répertoire</a>
            </div>
            <div class="panel-body">
                Vos répertoires :
                @foreach($userepo as $repository)
                    @if($repository->dossierPrimaire != 'Y')
                        @if($repository->dossierParent == Session::get('dossierActuel'))
                            <br>
                            <a class="btn btn-info" onclick="destination('{{ $repository->name }}')" href="{{ url('/repertoire') }}">{{ $repository->name }}</a>
                            {{ Session::put('destination',$repository->name) }}
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="container">

</div>
@endsection
