<?php

namespace App\Http\Controllers;

use App\fileEntries;
use Illuminate\Http\Request;
use App\repository;
use Illuminate\Support\Facades\Auth;

class afficherDossier extends Controller
{
    public function index()
    {
        //On récupère la variable de session cheminActuel qui n'est pas encore màj, elle correspond au dossier précédent
        $dossierPrec = session()->get('dossierActuel');

        //On concatène ensuite le chemin de l'ancien dossier avec le nom du dossier cible pour crée le chemin actuel
        $dossierActuel = $dossierPrec.session()->get('destination').'/';

        //On actualise le chemin actuel
        session()->put('dossierActuel',$dossierActuel);

        //On cherche les infos de l'utilisateur
        $user = Auth::user();

        //On cherche ensuite les dossiers et les fichiers par Id (on fera un tri dans la vue pour savoir quoi afficher)
        $userepo = repository::findRepoById($user->id);
        $userFile = fileEntries::findFileById($user->id);

        return view('repertoire',compact('userepo','userFile'));
    }
}
