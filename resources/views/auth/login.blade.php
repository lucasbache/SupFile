@extends('layouts.app')

@section('content')

        <div class="row">
            <div class="" style="padding-top: 5%">
                <div class="panel panel-default">
                    <div class="panel-body text center login-page">
                        <form class="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="">Adresse e-mail</label>

                                <div class="0">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div><br />
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="">Mot de passe</label>

                                <div class="">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="">
                                        <label class="message">
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Se souvenir de moi
                                        </label><br>
                                        <a class="message" href="{{ route('password.request') }}">
                                            Mot de passe oublié
                                        </a>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <button type="submit" class="">
                                        Connexion
                                    </button><br /><br />
                                    <a href="{{ url('login/facebook') }}" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                                    <a href="{{ url('login/twitter') }}" class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
                                    <a href="{{ url('login/google') }}" class="btn btn-social-icon btn-google-plus"><i class="fa fa-google-plus"></i></a>
                                </div>
                            </div>
    <!--                        <div class="form-group col-md-7 mx-auto">

                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
