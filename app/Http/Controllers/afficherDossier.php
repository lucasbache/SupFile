<?php

namespace App\Http\Controllers;

use App\fileEntries;
use Illuminate\Http\Request;
use App\repository;
use Illuminate\Support\Facades\Auth;
use App\Traits\FileTrait;
use App\Http\Requests\createRepoRequest;

class afficherDossier extends Controller
{
    use FileTrait;

    public function index($id)
    {

        $repo = repository::findRepoById($id);
        $reponame = $repo->name;

        //On récupère le chemin du dossier actuel
        $dossierActuel = $repo->cheminDossier;

        //On cherche les infos de l'utilisateur
        $user = Auth::user();

        //On liste tous les dossiers
        $listeDossierChemin = explode("/",$dossierActuel);
        $dossFic = explode("/",$dossierActuel);
        array_shift($dossFic);
        $dossierFichier = implode('.',$dossFic);

        $tailleTab = count($listeDossierChemin);

        $listeDossier = [];

        for($i = 1; $i<=$tailleTab ; $i++)
        {
            $path = implode("/",$listeDossierChemin);
            array_push($listeDossier, repository::findRepoByPath($path));
            array_pop($listeDossierChemin);
        }

        $listeDossier = array_reverse($listeDossier);

        $repo = repository::findRepoById($id);
        $repoPath = $repo->cheminDossier;

        //On cherche ensuite les dossiers et les fichiers par Id (on fera un tri dans la vue pour savoir quoi afficher)
        $userepo = repository::findRepoByUserId($user->id);
        $userFile = fileEntries::findFileById($user->id);

        return view('repertoire',compact('userepo','userFile','listeDossier','reponame', 'dossierActuel','repo','dossierFichier','repoPath'));
    }


    public function repoSubmit(createRepoRequest $request)
    {
        //On recherche les infos utilisateur
        $user = Auth::user();
        $userId = $user->id;

        //On récupère le nom du dossier et on crée le chemin du dossier qui va être crée
        $repoName = $request->input('name');
        $cheminDossier = $request->input('path').'/'.$repoName;

        $dossierActuel = $request->input('path');

        $dossierCree = $this->createRepo($userId, $repoName, $cheminDossier, $dossierActuel);

        return redirect('repertoire/'.$dossierCree)->with("success", "Le répertoire a bien été crée");
    }

}
