<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class fileEntries extends Model
{
    protected $fillable = ['user_id', 'name', 'cheminFichier', 'dossierStockage','tailleFichier', 'extension', 'preview_url'];

    public static function findFileByUserId($id)
    {
        $filebyid = DB::table('file_entries')->where('user_id', '=', $id)->get();
        return $filebyid;
    }

    public static function findFileById($id)
    {
        $filebyid = DB::table('file_entries')->where('id', '=', $id)->get();
        return $filebyid;
    }

    public static function findFileByRepo($cheminDossier)
    {
        $fileByRepo = DB::table('file_entries')->where('dossierStockage', '=', $cheminDossier)->get();
        return $fileByRepo;
    }

    public static function findAllFilesByPath($path)
    {
        $allFilesByPath = DB::table('file_entries')->where('dossierStockage', 'LIKE', "%{$path}%")->get();
        return $allFilesByPath;
    }

    public static function findFileCreate($id, $filename, $reponame)
    {
        $filecreate = DB::table('file_entries')
            ->where('user_id', '=', $id)
            ->where('name', '=', $filename)
            ->where('dossierStockage', '=', $reponame)
            ->get();
        return $filecreate;
    }

    public static function findFileByPath($path)
    {
        $filebyid = DB::table('file_entries')->where('cheminFichier', '=', $path)->get();
        return $filebyid;
    }

    public static function renameFile($id, $newName, $newPath){

        $renameFile = DB::table('file_entries')
            ->where('id', '=', $id)
            ->update(['name' => $newName, 'cheminFichier' => $newPath]);

        return $renameFile;
    }

    public static function updateFile($id, $newPath, $newRepoStock){

        $updateFile = DB::table('file_entries')
            ->where('id', '=', $id)
            ->update(['cheminFichier' => $newPath, 'dossierStockage' => $newRepoStock]);

        return $updateFile;
    }

    public static function suppressFile($id){

        $suppresFile = DB::table('file_entries')
            ->where('id', '=', $id)
            ->delete();

        return $suppresFile;
    }
}


