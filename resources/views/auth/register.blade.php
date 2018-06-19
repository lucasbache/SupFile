@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="">
            <div class="col-sm panel panel-default" style="margin-top: -5%;">
                <div class="panel-body">
                    <form class="form" method="POST" action="{{ route('register') }}" style="margin-left: 30%; margin-top: 10%;">
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

                        <div>
                            <input id="RGPD" type="checkbox" required>
                                <a href="" data-toggle="modal" data-target="#condition"
                                   class="open-modal">
                                    <label for="RGPD">
                                    En cochant cette case, <br>je déclare avoir pris connaissances des informations suivantes :
                                    </label>
                                </a>

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

<div class="modal fade" id="condition" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <form-group>
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Conditions d'inscription</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>
                            -	L’adresse mail (obligatoire) est utilisée pour le bon fonctionnement du service,
                            <br>
                            -	Le pseudo (obligatoire) est utilisé pour personnaliser l’environnement,
                            <br>
                            -	Seuls les administrateurs du site SupFile pourront prendre connaissance de ces données
                            <br>
                            -	Vous pouvez vous désinscrire du service SupFile en écrivant à roman.zitzmann@supinfo.com
                        </label>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer
                        </button>
                    </div>
                </form-group>
            </form>

        </div>
    </div>
</div>
@endsection
