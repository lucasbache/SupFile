@extends('layouts.app')

@if(Session::has('success'))
    <div class="alert alert-info">
        {{ Session::get('success') }}
    </div>
@endif

@section('content')

    <div class="col-md-8 col-md-offset-2">
        <form method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            Nom du fichier:
            <br />
            <input type="text" name="name" />
            <br /><br />
            Séléctionner votre fichier:
            <br />
            <input type="file" name="photos[]" multiple />
            <br /><br />
            <input type="submit" value="Upload" />
        </form>
    <div class="col-md-8 col-md-offset-2">

@endsection
