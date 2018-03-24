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
            foreach ($request->photos as $photo) {
                //On récupère les informations de l'utilisateur
                $user = Auth::user();

                //On prépare le dossier dans lequel va être stocké le fichier
                $dossierActuel = session()->get('dossierActuel');

                //On insert le fichier dans le répertoire
                $filepath = $photo->store($dossierActuel);

                //On créer le fichier dans la base de donnée
                fileEntries::create([
                    'user_id' => $user->id,
                    'name' => $request->input('name'),
                    'cheminFichier' => $filepath,
                    'dossierStockage' => $dossierActuel
                ]);
            }

            return redirect()->back()->with("success", "Le fichier a bien été envoyé !");
        }
        else{
            return redirect()->back()->with("error", "Aucun fichier n'a été sélectionné !");
        }
    }
}
