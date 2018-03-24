@extends('layouts.app')
@if (count($errors) > 0)
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
@if(Session::has('success'))
    <div class="alert alert-info">
        {{ Session::get('success') }}
    </div>
@endif

@section('content')<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <form method="post" enctype="multipart/form-data">
            <form-group>
                {{ csrf_field() }}
                Nom du dossier
                <br />
                <input type="text" name="name" />
                <br /><br />
                <input type="submit" value="Créer" />
            </form-group>
        </form>
    </div>
</div>
@endsection