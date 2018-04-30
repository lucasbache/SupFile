<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class repository extends Model
{
    protected $fillable = ['user_id', 'name', 'dossierPrimaire', 'cheminDossier', 'dossierParent'];

    public static function findRepoByUserId($id)
    {
        $repobyid = DB::table('repositories')->where('user_id', '=', $id)->get();
        return $repobyid;
    }
    public static function findRepoById($id)
    {
        $repobyid = DB::table('repositories')->where('id', '=', $id)->get();
        return $repobyid->first();
    }
    public static function findRepoByPath($path)
    {
        $repobypath = DB::table('repositories')->where('cheminDossier', '=', $path)->get();
        return $repobypath->first();
    }

    public static function findRepoByPathMulti($path)
    {
        $repobypath = DB::table('repositories')->where('cheminDossier', '=', $path)->get();
        return $repobypath;
    }

    public static function findRepoByParentPath($path)
    {
        $repobypath = DB::table('repositories')->where('dossierParent', '=', $path)->get();
        return $repobypath->first();
    }

    public static function findRepoCreate($id, $repoName, $dossierStockage)
    {
        $repoCreate = DB::table('repositories')
            ->where('user_id', '=', $id)
            ->where('name', '=', $repoName)
            ->where('cheminDossier', '=', $dossierStockage)
            ->get();
        return $repoCreate;
    }
}
