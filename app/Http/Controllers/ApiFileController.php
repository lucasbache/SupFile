<?php

namespace App\Http\Controllers;

use App\repository;
use App\fileEntries;
use App\Traits\FileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiFileController extends Controller
{
    use FileTrait;

    public function upload(Request $request){
        $dossierActuel = $request['folder'];
        $file = $request['file'];
        $nomFicComplet = $request['filename'];
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
        $parentpath = $request['parent'];
        $repoName = $request['name'];
        $cheminDossier = $parentpath.'/'.$repoName;

        if(strlen($uid)==0 || strlen($parentpath)==0 || strlen($repoName)==0){
            return json_encode(array('error' => 'missing parameters'));
        }
        else
        {
            $this->createRepo($uid, $repoName, $cheminDossier, $parentpath);
            return json_encode(array('success' => 'repository successfully created'));
        }
    }

    public function downloadFileApi(Request $request){
        $filename = $request['filename'];
        $folder = $request['folder'];
        $email = $request->user()->email;

        return $this->downloadFile($filename, $folder, $email);
    }

    public function listFiles(Request $request){
        $path = $request['path'];

        if(strlen($path)==0 ){
            return json_encode(array('error' => 'missing parameters'));
        }
        else
        {
            $repodata = [];
            $filedata = [];

            $repo = repository::findRepoByPathMulti($path);
            $files = fileEntries::findFileByPath($path);

            foreach($repo as $r){
                array_push($repodata, $r->name);
            }

            foreach($files as $f){
                array_push($filedata, $f->name);
            }

            $data = array( "folders" => $repodata, "files" => $filedata);

            return json_encode($data);
        }
    }

}
