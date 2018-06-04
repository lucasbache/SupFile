@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="row mx-auto">
        <div class="col-md-8 col-md-offset-2 mx-auto">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}" style="margin-left: 30%; margin-top: 10%;">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-10 control-label">Pseudo</label>
                            <div class="col-md-8">
                                @if(!empty($name))
                                    <input id="name" type="text" class="form-control" name="name" value="{{$name}}" required autofocus>
                                @else
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                @endif
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                       <strong>{{ $errors->first('name') }}</strong>
                                   </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-8 control-label">Adresse e-mail</label>
                            <div class="col-md-8">
                                @if(!empty($email))
                                    <input id="email" type="email" class="form-control" name="email" value="{{$email}}" required>
                                @else
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                @endif
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                       <strong>{{ $errors->first('email') }}</strong>
                                   </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-6 control-label">Mot de passe</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-6 control-label">Confirmation</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="col-md-16">
                                <button type="submit" class="btn btn-primary">
                                    S'inscrire
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
