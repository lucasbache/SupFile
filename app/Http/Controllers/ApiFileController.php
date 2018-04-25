<?php

namespace App\Http\Controllers;

use App\repository;
use App\Traits\FileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiFileController extends Controller
{
    use FileTrait;

    public function upload(Request $request){
        $dossierActuel = $request['dossierActuel'];
        $file = $request['file'];
        $nomFicComplet = $request['nomFicComplet'];
        $uid = $request->user()->id;

        if(strlen($uid)==0 || strlen($dossierActuel)==0 || strlen($file)==0 || strlen($nomFicComplet)==0){
            return json_encode(array('error' => 'missing parameters'));
        }
        else
        {
            $this->uploadFile($uid, $dossierActuel, $file, $nomFicComplet);
            return json_encode(array('success' => 'file upload successful'));
        }
    }

    public function repoCreate(Request $request){

        $uid = $request->user()->id;
        $dossierActuel = $request['dossierActuel'];
        $repoName = $request['repoName'];
        $cheminDossier = $request['cheminDossier'];

    }
}
