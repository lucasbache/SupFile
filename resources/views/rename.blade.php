@extends('layouts.app')
@if (count($errors) > 0)
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

@section('content')<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <form method="post" enctype="multipart/form-data">
            <form-group>
                {{ csrf_field() }}
                Nom :
                <br />
                <input type="text" name="name" />
                <input type="hidden" name="id" value="{{$id}}" />
                <br /><br />
                <input type="Submit" value="Valider" />
            </form-group>
        </form>
    </div>
</div>
@endsection