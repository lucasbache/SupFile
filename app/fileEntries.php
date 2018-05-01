<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class fileEntries extends Model
{
    protected $fillable = ['user_id', 'name', 'cheminFichier', 'dossierStockage',];

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

    public static function findFileCreate($id, $filename, $reponame)
    {
        $filecreate = DB::table('file_entries')
            ->where('user_id', '=', $id)
            ->where('name', '=', $filename)
            ->where('dossierStockage', '=', $reponame)
            ->get();
        return $filecreate;
    }

    public static function renameFile($id, $newName, $newPath){

        $renameFile = DB::table('file_entries')
            ->where('id', '=', $id)
            ->update(['name' => $newName, 'cheminFichier' => $newPath]);

        return $renameFile;
    }
}


