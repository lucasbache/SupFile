@extends('layouts.app')

@section('content')

<head>


</head>

<body>
<div class="header-full">
    <div class="hero">
        <img id="logo-big" class="d-inline-block mr-1" src="{{ asset('Images/supfileBig.png') }}" height="150" alt="SUPFILE">
        <p>L'outil simple et puissant de stockage en ligne.</p>
        <a href="/contact" class="btn btn-primary">À propos de nous</a>
        <a class="js-smooth" href="#howto"><div class="btn btn-primary">Comment faire ?</div></a>
    </div>
</div>

<div class="section light-bg" id="features">


    <div class="container">

        <div class="section-title" style="margin-top: 3%;">
            <h3>Pourquoi SupFile ?</h3>
        </div>


        <div class="row" style="margin-top: 0%">
            <div class="col-12 col-lg-4">
                <div class="">
                <div class="howto-cards card features">
                    <div class="card-body">
                        <div class="media">
                            <span class="ti-face-smile gradient-fill ti-3x mr-3"></span>
                            <div class="media-body" style="height: 160px;">
                                <h4 class="card-title">Simple</h4>
                                <p class="card-text" style="text-align: justify">SupFile est l'outil de stockage et de partage de fichiers facile d'utilisation que vous attendiez. En un clic, stockez ou téléchargez vos fichiers n'importe où dans le monde.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="howto-cards card features">
                    <div class="card-body">
                        <div class="media">
                            <span class="ti-settings gradient-fill ti-3x mr-3"></span>
                            <div class="media-body" style="height: 160px;">
                                <h4 class="card-title">Personnalisé</h4>
                                <p class="card-text" style="text-align: justify">Organisez vos fichiers comme bon vous semble, classez-les dans des dossiers et consultez-les en ligne grâce à la puissance de SupFile.</p><br />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="howto-cards card features">
                    <div class="card-body">
                        <div class="media">
                            <span class="ti-lock gradient-fill ti-3x mr-3"></span>
                            <div class="media-body" style="height: 160px;">
                                <h4 class="card-title">Disponible</h4>
                                <p class="card-text" style="text-align: justify">La force de SupFile réside dans sa disponibilité à chaque instant, peu importe votre emplacement sur la planète. Stockez votre photo à Paris, partagez-la à Tokyo !</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



</div>
<div id="howto"></div>
<div class="section light-bg" style="margin-top: 5%;">
    <div class="container">
        <div class="row">
            <div class="section-title" style="margin-top: 3%; margin-right: 4%;">
                <h3>Comment faire ?</h3>
            </div>
            <div class="col-md-8 d-flex align-items-center">
                <ul class="list-unstyled ui-steps">
                    <li class="media">
                        <div class="circle-icon mr-4">1</div>
                        <div class="media-body">
                            <h5>Créez votre compte...</h5>
                            <p>En cliquant sur le bouton d'insciption, créez votre compte grâce à votre adresse e-mail, ou votre compte Facebook, Twitter et Google. Vous serez ensuite prêt à utiliser SupFile.</p>
                        </div>
                    </li>
                    <li class="media my-4">
                        <div class="circle-icon mr-4">2</div>
                        <div class="media-body">
                            <h5>Uploadez vos premiers fichiers...</h5>
                            <p>Une fois sur la page d'accueil, commencez à uploader vos fichiers directement à la source ou créez un dossier grâce au bouton dédié, puis cliquez sur le bouton d'ajout de fichier.</p>
                        </div>
                    </li>
                    <li class="media">
                        <div class="circle-icon mr-4">3</div>
                        <div class="media-body">
                            <h5>Vous avez déjà SupFile en main !</h5>
                            <p>Et voilà ! Vous connaissez déjà les fonctionnalités de base de SupFile.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>

<div class="section pt-0" style="margin-top: 3%;">
    <div class="container">
        <div class="section-title">
            <h3>Foire aux questions</h3>
        </div>

        <div class="row pt-4">
            <div class="col-md-6">
                <h4 class="mb-3">Comment utiliser SupFile ?</h4>
                <p class="light-font mb-5">Pour pouvoir utiliser SupFile, il vous suffit d'être possesseurs d'une adresse e-mail et de fichiers à stocker... <a href="{{ route('register') }}">Inscrivez-vous</a> et commencez à utiliser SupFile tout de suite !</p>
                <h4 class="mb-3">Combien coûte SupFile ?</h4>
                <p class="light-font mb-5">SupFile est un service que nous vous proposons gratuitement. Plus besoin d'abonnement mensuel pour utiliser le Cloud !</p>

            </div>
            <div class="col-md-6">
                <h4 class="mb-3">Pourquoi SupFile ?</h4>
                <p class="light-font mb-5">SupFile regroupe toutes les fonctionnalités indispensables pour le stockage et la gestion de vos fichiers, sans rajouter la surcouche inutile qui ralentit et complexifie votre expérience. Rapide et efficace, SupFile va droit au but ! </p>
                <h4 class="mb-3">Y'a-t-il une limite de taille sur SupFile ?</h4>
                <p class="light-font mb-5">Pour que l'expérience de chacun soit la plus agréable possible, SupFile limite l'espace de stockage à 30 Go. De quoi envoyer quelques milliers de photos avant de se sentir limité....  </p>

            </div>
        </div>
    </div>

</div>

</body>

</html>

@endsection
