<?php

namespace App\Http\Controllers;

use App\fileEntries;
use Illuminate\Http\Request;
use App\repository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\renameRequest;
use App\Traits\FileTrait;
use App\Http\Requests\createRepoRequest;

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

        $repo = repository::findRepoById($id);
        $repoPath = $repo->cheminDossier;

        //On cherche ensuite les dossiers et les fichiers par Id (on fera un tri dans la vue pour savoir quoi afficher)
        $userepo = repository::findRepoByUserId($user->id);
        $userFile = fileEntries::findFileByUserId($user->id);

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

    public function renameForm($idFile,$idRepo,$objectType){

        $idFic = $idFile;
        $idDoss = $idRepo;
        $objTyp = $objectType;
        return view('rename', compact('idFic','idDoss','objTyp'));
    }

    public function renameSubmit(renameRequest $request){

        $newName = $request->input('name');
        $objectId = $request->input('id');
        $repoId = $request->input('idDoss');
        $objectType = $request->input('objectType');


        if($objectType == 'F')
        {
            $this->renameFiles($objectId,$newName);
        }
        else
        {
            $this->renameRepo($objectId,$newName);
        }

        return redirect('repertoire/'.$repoId)->with("success", "Nouveau nom pris en compte");
    }

    public function suppressFile($fileId, $objectType,$dossierId,$typeDoss){

        $this->suppress($objectType,$fileId);

        if($typeDoss == 'Prim' )
        {
            return redirect('home');
        }
        else{
            return redirect('repertoire/'.$dossierId);
        }

    }

}
