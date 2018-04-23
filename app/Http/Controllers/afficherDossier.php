<?php

namespace App\Http\Controllers;

use App\fileEntries;
use Illuminate\Http\Request;
use App\repository;
use Illuminate\Support\Facades\Auth;

class afficherDossier extends Controller
{
    public function index($id)
    {

        $repo = repository::findRepoById($id);
        $reponame = $repo->name;

        //On concatène ensuite le chemin de l'ancien dossier avec le nom du dossier cible pour crée le chemin actuel
        $dossierActuel = $repo->cheminDossier;

        //On cherche les infos de l'utilisateur
        $user = Auth::user();

        //On liste tous les dossiers
        $listeDossierChemin = explode("/",$dossierActuel);
        $dossierFichier = implode('.',$listeDossierChemin);

        $tailleTab = count($listeDossierChemin);

        $listeDossier = [];

        for($i = 1; $i<=$tailleTab ; $i++)
        {
            $path = implode("/",$listeDossierChemin);
            array_push($listeDossier, repository::findRepoByPath($path));
            array_pop($listeDossierChemin);
        }
        $listeDossier = array_reverse($listeDossier);
        //$listeDossierColl = collect($listeDossier);
        //On cherche ensuite les dossiers et les fichiers par Id (on fera un tri dans la vue pour savoir quoi afficher)
        $userepo = repository::findRepoByUserId($user->id);
        $userFile = fileEntries::findFileById($user->id);

        return view('repertoire',compact('userepo','userFile','listeDossier','reponame', 'dossierActuel','repo','dossierFichier'));
    }

}
