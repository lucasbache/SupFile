<?php

namespace App\Traits;
use App\fileEntries;
use App\repository;
use Storage;
use File;

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
                $repoName = $repoName."(".$compteur.")";
            }
            else
            {
                $repoName = $repoName."(".$compteur.")";
            }

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

        Storage::makeDirectory($cheminDossier, 777, true);
        return $dossier->id;
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

    public function downloadFile($userEmail, $dossierFichier, $filename){

        if($dossierFichier == $userEmail)
        {
            $fileDownload = $dossierFichier.'/'.$filename;
        }
        else
        {
            $cheminPoint = explode('.', $dossierFichier);
            array_unshift($cheminPoint, $userEmail);
            $dossierActuel = implode('/', $cheminPoint);

            $fileDownload = $dossierActuel.'/'.$filename;
        }
        return Storage::download($fileDownload);
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

        Storage::move($file->cheminFichier, $dossFichier);

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

        Storage::move($dossier->cheminDossier, $cheminDossier);

        return $dossier;

    }

}