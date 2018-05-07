<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use App\fileEntries;
use Illuminate\Support\Facades\Auth;
use App\repository;
use App\Traits\FileTrait;

class UploadController extends Controller
{
    use FileTrait;

    public function uploadForm($id, $typeDoss)
    {
        $repo = repository::findRepoById($id);
        $repoPath = $repo->cheminDossier;
        return view('upload',compact('repoPath','id', 'typeDoss'));
    }

    public function uploadSubmit(UploadRequest $request)
    {
        $typeDoss = null;
        $idRepo = null;

        if ($request != null) {
            foreach ($request->photos as $file) {
                //On récupère les informations de l'utilisateur
                $user = Auth::user();
                $userId = $user->id;

                //On prépare le dossier dans lequel va être stocké le fichier
                $dossierActuel = $request->input('path');

                //On récupère le nom du fichier
                $nomFicComplet = $_FILES['photos']['name'][0];

                $idRepo = $request->input('id');

                $typeDoss = $request->input('typeDoss');

                $this->uploadFile($userId, $dossierActuel, $file, $nomFicComplet);
            }

            if($typeDoss == 'Prim')
            {
                return redirect('home');
            }
            else{
                return redirect('repertoire/'.$idRepo)->with("success", "Le fichier a bien été envoyé !");
            }
        }
        else{
            return redirect()->action('afficherDossier@index')->with("error", "Aucun fichier n'a été sélectionné !");
        }
    }

}
