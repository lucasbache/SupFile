<?php

namespace App\Http\Controllers;

use App\fileEntries;
use Illuminate\Http\Request;
use App\repository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\renameRequest;
use App\Traits\FileTrait;

class repoController extends Controller
{

    use FileTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


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

        //On cherche ensuite les dossiers et les fichiers par Id (on fera un tri dans la vue pour savoir quoi afficher)
        $userepo = repository::findRepoByUserId($user->id);
        $userFile = fileEntries::findFileByUserId($user->id);

        return view('repertoire',compact('userepo','userFile','listeDossier','reponame', 'dossierActuel','repo','dossierFichier'));
    }

    public function renameFileForm($idFile){

        $id = $idFile;
        return view('rename', compact('id'));
    }

    public function renameFileSubmit(renameRequest $request){

        $newName = $request->input('name');
        $fileId = $request->input('id');

        $this->renameFiles($fileId,$newName);

        return view('home');

    }

}
