<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class repository extends Model
{
    protected $fillable = ['user_id', 'name', 'dossierPrimaire', 'cheminDossier', 'dossierParent'];

    public static function findRepoById($id)
    {
        $repobyid = DB::table('repositories')->where('user_id', '=', $id)->get();
        return $repobyid;
    }
}
