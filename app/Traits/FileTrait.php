<?php

namespace App\Traits;
use App\fileEntries;
use App\repository;
use Storage;
use File;
use COM;
use Zipper;
use Illuminate\Support\Facades\Auth;
use App\stockage;


trait FileTrait
{
    public function createRepo($userId, $repoName, $cheminDossier, $dossierActuel){

        $sameRepo = repository::findRepoCreate($userId, $repoName, $cheminDossier);
        $compteur = 0;
        while(!$sameRepo->isEmpty())
        {
            $compteur += 1;
            if($compteur > 1)
            {
                $prefixFile = explode("(", $repoName);
                $repoName = $prefixFile[0]."(".$compteur.")";
            }else{
                $repoName = $repoName."(".$compteur.")";
            }
            $cheminDossier = $dossierActuel."/".$repoName;
            $sameRepo = null;
            $sameRepo = repository::findRepoCreate($userId, $repoName, $cheminDossier);
        }

        //On crée le dossier
        $dossier = repository::create([
            'user_id' => $userId,
            'name' => $repoName,
            'dossierPrimaire' => 'N',
            'cheminDossier' => $cheminDossier,
            'dossierParent' => $dossierActuel
        ]);

        File::makeDirectory($cheminDossier, 777, true);
        return $dossier->id;
    }

    public function uploadFile($userId, $dossierActuel, $file, $nomFicComplet, $tailleFichier){

        //On vérifie que le stockage ne dépasse pas 30Go
        $stockageUtilise = stockage::findSizeByUserId($userId)->first();

        if($stockageUtilise->stockageUtilise > 30000000000)
        {
            return false;
        }
        else{

            $nouvelleTailleFic = $stockageUtilise->stockageUtilise + $tailleFichier;
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
            //dd($tailleFichier);
            //On créer le fichier dans la base de donnée
            fileEntries::create([
                'user_id' => $userId,
                'name' => $nomFicComplet,
                'cheminFichier' => $filepath,
                'dossierStockage' => $dossierActuel,
                'tailleFichier' => $tailleFichier
            ]);

            stockage::updateStorage($userId,$nouvelleTailleFic);

            return true;
        }
    }

    public function downloadFiles($dossierFichier){

        return response()->download($dossierFichier);
    }

    public function downloadRepos($dossier){

        $files = glob($dossier->cheminDossier);

        Zipper::make('public/'.$dossier->name)->add($files)->close();

        return response()->download('public/'.$dossier->name);
    }

    public function renameFiles($objectId, $newName){

        $file = fileEntries::findFileById($objectId)->first();

        $explodeFile = explode('.',$file->name);
        $extensionFile = last($explodeFile);
        $newNameFile =$newName.".".$extensionFile;

        $nouveauCheminFic = explode("/",$file->cheminFichier);
        array_pop($nouveauCheminFic);
        array_push($nouveauCheminFic, $newNameFile);
        $dossFichier = implode('/', $nouveauCheminFic);

        fileEntries::renameFile($objectId, $newNameFile, $dossFichier);

        File::move($file->cheminFichier, $dossFichier);

        return $file;

    }

    public function renameRepo($objectId, $newName){

        $dossier = repository::findRepoById($objectId);

        $fichierDossier = fileEntries::findFileByRepo($dossier->cheminDossier);

        $dossierEnfant = repository::findRepoByStock($dossier->cheminDossier);

        foreach ($fichierDossier as $fichier)
        {
            $nouveauDossStock = explode("/",$fichier->dossierStockage);
            array_pop($nouveauDossStock);
            array_push($nouveauDossStock, $newName);
            $dossStockFichier = implode('/', $nouveauDossStock);

            $cheminFich = explode('/',$fichier->cheminFichier);
            array_pop($cheminFich);
            array_pop($cheminFich);
            array_push($cheminFich, $newName);
            array_push($cheminFich, $fichier->name);
            $nouveauCheminFich = implode('/', $cheminFich);

            fileEntries::updateFile($fichier->id, $nouveauCheminFich, $dossStockFichier );
        }

        foreach ($dossierEnfant as $dossEnfant)
        {
            $nouveauDossParent = explode('/', $dossEnfant->dossierParent);
            array_pop($nouveauDossParent);
            array_push($nouveauDossParent, $newName);
            $dossierParent = implode('/', $nouveauDossParent);

            $nouveauCheminDoss = explode('/', $dossEnfant->cheminDossier);
            array_pop($nouveauCheminDoss);
            array_pop($nouveauCheminDoss);
            array_push($nouveauCheminDoss, $newName);
            array_push($nouveauCheminDoss, $dossEnfant->name);
            $cheminDoss = implode('/', $nouveauCheminDoss);

            repository::updateRepo($dossEnfant->id, $cheminDoss, $dossierParent);
        }

        $nouveauCheminDossier = explode('/',$dossier->cheminDossier);
        array_pop($nouveauCheminDossier);
        array_push($nouveauCheminDossier, $newName);
        $cheminDossier = implode('/',$nouveauCheminDossier);

        repository::renameRepo($objectId, $newName, $cheminDossier);

        File::move($dossier->cheminDossier, $cheminDossier);

        return $dossier;

    }

    public function suppress($objectType, $objectId){

        $user = Auth::user();

        //On veut supprimer un dossier
        if($objectType == 'D'){
            $stockageUser = stockage::findSizeByUserId($user->id)->first();

            $repo = repository::findRepoById($objectId);
            $objectPath = $repo->cheminDossier;

            $sousDossier = repository::findAllRepoByPath($objectPath);
            $sousFichier = fileEntries::findAllFilesByPath($objectPath);

            foreach($sousDossier as $sousDoss)
            {
                repository::suppressRepo($sousDoss->id);
            }

            foreach($sousFichier as $sousFic)
            {
                fileEntries::suppressFile($sousFic->id);
            }

            $chmDos = explode('/',$objectPath);
            $cheminDossier = implode('\\', $chmDos);

            $f = "C:\wamp64\www\SupDrive\public\\".$cheminDossier;
            $obj = new COM ( 'scripting.filesystemobject' );
            $ref = $obj->getfolder ( $f );

            $nouveauStockage = $stockageUser->stockageUtilise - $ref->size;
            stockage::updateStorage($user->id, $nouveauStockage);

            repository::suppressRepo($objectId);
            File::deleteDirectory($objectPath);
        }
        //On veut supprimer un fichier
        else{
            //On récupère la taille du stockage utilisé par l'utilisateur et l'objet "Fichier"
            $stockageUser = stockage::findSizeByUserId($user->id)->first();
            $file = fileEntries::findFileById($objectId)->first();

            //On crée la nouvelle taille de stockage et on update la bdd
            $nouveauStockage = $stockageUser->stockageUtilise - $file->tailleFichier;
            stockage::updateStorage($user->id, $nouveauStockage);

            //On obtient le chemin du fichier à supprimer
            $objectPath = $file->cheminFichier;
            fileEntries::suppressFile($objectId);
            File::delete($objectPath);
        }
    }

}