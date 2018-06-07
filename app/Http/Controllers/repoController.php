<?php

namespace App\Http\Controllers;

use App\fileEntries;
use Illuminate\Http\Request;
use App\repository;
use Illuminate\Support\Facades\Auth;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Input;

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

    public function postRepo(Request $request)
    {

        //check which submit was clicked on
        if(Input::get('createRepoButton')) {

            return $this->repoSubmit($request);
        }
        elseif(Input::get('uploadFileButton')) {

            return $this->uploadSubmit($request);
        }
        else{
            return $this->renameSubmit($request);
        }

    }

    public function index($id = 'h')
    {
        //On cherche les infos de l'utilisateur
        $user = Auth::user();

        if ($id == 'h'){
            $repo = repository::findRepoByPath($user->email);
        }else{
            $repo = repository::findRepoById($id);
        }

        $reponame = $repo->name;

        //On récupère le chemin du dossier actuel
        $dossierActuel = $repo->cheminDossier;

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

        $repoPath = $repo->cheminDossier;

        //On cherche ensuite les dossiers et les fichiers par Id (on fera un tri dans la vue pour savoir quoi afficher)
        $userepo = repository::findRepoByUserId($user->id);
        $userFile = fileEntries::findFileByUserId($user->id);

        return view('repertoire',compact('userepo','userFile','listeDossier','reponame', 'dossierActuel','repo','dossierFichier','repoPath','id', 'typeDoss'));
    }


    public function repoSubmit(Request $request)
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

    public function renameSubmit(Request $request){

        $newName = $request->input('name');
        $objectId = $request->input('eventId');
        $repoId = $request->input('idDoss');
        $objectType = $request->input('objectType');

        //Si le type d'objet est F (file), on appel la fonction renameFiles
        if($objectType == 'F')
        {
            $this->renameFiles($objectId,$newName);
        }
        //Sinon, c'est un dossier
        else
        {
            $this->renameRepo($objectId,$newName);
        }

        return redirect('repertoire/'.$repoId)->with("success", "Nouveau nom pris en compte");
    }

    public function suppressObject($objectId, $objectType,$dossierId,$typeDoss){

        $this->suppress($objectType,$objectId);

        if($typeDoss == 'storage' )
        {
            return redirect('home');
        }
        else{
            return redirect('repertoire/'.$dossierId);
        }

    }

    public function uploadSubmit(Request $request)
    {
        $typeDoss = null;
        $idRepo = null;
        $retourUpload = false;

        if ($request != null) {
            foreach ($request->photos as $file) {
                //On récupère les informations de l'utilisateur
                $user = Auth::user();
                $userId = $user->id;

                //On prépare le dossier dans lequel va être stocké le fichier
                $dossierActuel = $request->input('path');

                //On récupère le nom du fichier
                $nomFicComplet = $_FILES['photos']['name'][0];

                //On récupère la taille du fichier
                $tailleFic = $_FILES['photos']['size'][0];

                $idRepo = $request->input('id');

                $typeDoss = $request->input('typeDoss');

                $retourUpload = $this->uploadFile($userId, $dossierActuel, $file, $nomFicComplet, $tailleFic);
            }

            if($typeDoss == 'storage/')
            {
                if($retourUpload == true)
                {
                    return redirect('home')->with("success", "Le fichier a bien été envoyé !");
                }
                else{
                    return redirect('home')->with("error", "Limite de stockage atteinte");
                }
            }
            else{
                if($retourUpload == true)
                {
                    return redirect('repertoire/'.$idRepo)->with("success", "Le fichier a bien été envoyé !");
                }
                else{
                    return redirect('repertoire/'.$idRepo)->with("error", "Limite de stockage atteinte");
                }
            }
        }
        else{
            return redirect()->action('afficherDossier@index')->with("error", "Aucun fichier n'a été sélectionné !");
        }
    }

}
