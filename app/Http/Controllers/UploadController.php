<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;
use App\fileEntries;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function uploadForm()
    {
        return view('upload');
    }

    public function uploadSubmit(UploadRequest $request)
    {
        if ($request != null) {
            foreach ($request->photos as $file) {
                //On récupère les informations de l'utilisateur
                $user = Auth::user();
                $userId = $user->id;

                //On prépare le dossier dans lequel va être stocké le fichier
                $dossierActuel = session()->get('dossierActuel');

                //On récupère le nom du fichier
                $nomFicComplet = $_FILES['photos']['name'][0];

                $this->uploadFile($userId, $dossierActuel, $file, $nomFicComplet);

            }

            return redirect()->back()->with("success", "Le fichier a bien été envoyé !");
        }
        else{
            return redirect()->back()->with("error", "Aucun fichier n'a été sélectionné !");
        }
    }

    public function uploadFile($userId, $dossierActuel, $file, $nomFicComplet){

        //On vérifie que le fichier n'existe pas
        $sameFile = fileEntries::findFileCreate($userId, $nomFicComplet, $dossierActuel);
        $compteur = 0;
        while(!$sameFile->isEmpty())
        {
            $compteur += 1;
            if($compteur > 1)
            {
                $prefixFile = explode("(", $nomFicComplet);
                $extension = explode(".", end($prefixFile));
                $nomFicComplet = $prefixFile[0]."(".$compteur.")".".".end($extension);
            }
            else
            {
                $explodeFile = explode(".", $nomFicComplet);
                $prefixFile = $explodeFile[0] . '(' . $compteur . ')';
                $nomFicComplet = $prefixFile . '.' . end($explodeFile);
            }

            $sameFile = null;
            $sameFile = fileEntries::findFileCreate($userId, $nomFicComplet, $dossierActuel);
        }

        //On insert le fichier dans le répertoire
        $filepath = $file->storeAs($dossierActuel, $nomFicComplet);

        //On créer le fichier dans la base de donnée
        fileEntries::create([
            'user_id' => $userId,
            'name' => $nomFicComplet,
            'cheminFichier' => $filepath,
            'dossierStockage' => $dossierActuel
        ]);

    }
}
