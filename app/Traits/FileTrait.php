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

        Storage::makeDirectory($cheminDossier, 0777, true);
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

    public function downloadFile($fileDownload){

        return Storage::download($fileDownload);
    }

}