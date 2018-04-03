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
                $nomFichier = $request->input('name');

                //On prépare le dossier dans lequel va être stocké le fichier
                $dossierActuel = session()->get('dossierActuel');

                $this->uploadFile($userId, $nomFichier, $dossierActuel, $file);

            }

            return redirect()->back()->with("success", "Le fichier a bien été envoyé !");
        }
        else{
            return redirect()->back()->with("error", "Aucun fichier n'a été sélectionné !");
        }
    }

    public function uploadFile($userId, $nomFichier, $dossierActuel, $file){

        //On insert le fichier dans le répertoire
        //$filepath = $file->storeAs($dossierActuel, $request->input('name'));
        $filepath = $file->store($dossierActuel);

        //On créer le fichier dans la base de donnée
        fileEntries::create([
            'user_id' => $userId,
            'name' => $nomFichier,
            'cheminFichier' => $filepath,
            'dossierStockage' => $dossierActuel
        ]);

    }
}
