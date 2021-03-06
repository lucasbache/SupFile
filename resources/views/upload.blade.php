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
            <br />
            <input type="text" name="name" value="rien" hidden/>
            <br /><br />
            Séléctionnez votre fichier:
            <br />
            <input type="file" name="photos[]" accept="file_extension|video/mp4|image/*|media_type"/>
            <input type="hidden" name="path" value="{{$repoPath}}" />
            <input type="hidden" name="id" value="{{$id}}" />
            <input type="hidden" name="typeDoss" value="{{$typeDoss}}" />
            <br /><br />
            <input type="submit" value="Upload" />
        </form>
    </div>

@endsection
