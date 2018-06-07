@extends('layouts.app')

@section('content')
    {{ Form::open(array('url' => '/profil')) }}
        <div class="row" style="margin-bottom: 30%; margin-top: -5%;">
                <div class="panel panel-default" style="padding-top: 5%">
                    <div class="panel-body text center login-page login-cont">
                        @if (session('error'))
                            <div class="notice notice-alert alert-dismissible fade show fixed-top">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="notice notice-success alert-dismissible fade show fixed-top">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="panel-body text center login-page login-cont">
                            <div class="form">
                        <form class="form" method="POST" action="{{ route('profil') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="control-label">Pseudo</label>

                                <div class="">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <input type="submit" class="btn btn-primary" name="info" value="Modifier">
                                </div>
                            </div>

                            <div style="margin-top: 10%;" class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="">Mot de passe actuel :</label>

                                <div class="">
                                    <input id="current-password" type="password" class="form-control" name="current-password">

                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="control-label">Nouveau mot de passe</label>

                                <div class="">
                                    <input id="new-password" type="password" class="form-control" name="new-password">

                                    @if ($errors->has('new-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new-password-confirm" class=" control-label">Confirmation</label>

                                <div class="">
                                    <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <input type="submit" class="btn btn-primary" name="password" value="Valider">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label">Stockage disponible</label>
                                <div class="">
                                    <p> {{$arrondiStockage}} Go</p>
                                </div>
                                <div class="progress" style="margin-bottom: -5%;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: {{$pourcentageStockage}}%" role="progressbar" aria-valuenow="{{$arrondiStockage}}" aria-valuemin="0" aria-valuemax="30"></div>
                                </div>
                            </div>
                        </form>
                        </div>
                        </div>
                    </div>
                </div>
        </div>
    {{ Form::close() }}
@endsection