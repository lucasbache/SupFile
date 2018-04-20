<?php

namespace App\Http\Controllers;

use App\repository;
use App\Traits\FileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiFileController extends Controller
{
    use FileTrait;

    public function upload($request){
        $uid = $request['uid'];
        $dossierActuel = $request['dossierActuel'];
        $file = $request['file'];
        $nomFicComplet = $request['nomFicComplet'];

        if(strlen($uid)==0 || strlen($dossierActuel)==0 || strlen($file)==0 || strlen($nomFicComplet)==0){
            return json_encode(array('error' => 'missing parameters'));
        }
        else {

        }
    }
}
