<?php

namespace App\Http\Controllers\Auth;

use App\repository;
use App\User;
use App\stockage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use File;
use Storage;
use Illuminate\Support\Facades\Crypt;
use MicrosoftAzure\Storage\File\FileRestProxy;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $userid = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $repoName = $data['email'];

        File::makeDirectory($repoName.'/', 777, true);

        $connectionString = 'DefaultEndpointsProtocol=https;AccountName=supfiledisk2;AccountKey=4tTfRML46yoQrkdanKHiktLvEy91fZZZ+x7MZo8Th2lMmaSG/W0BbOef7+Wf6UlIJ7pYv6rDcYMR7T3TOPsTTA==';
        $connectionString2 = 'DefaultEndpointsProtocol=https;AccountName=supfiledisk3;AccountKey=R5AZ0KNGAuG9pa/PrUQ5lJzLbP59/dJWG7ocLaUnSi1m/g1BjL4Dciw2fQVVATtlIOc7ZvI5bmaUXapbFy4x2g==';
        $connectionString3 = 'DefaultEndpointsProtocol=https;AccountName=supfiledisk4;AccountKey=Gvhg1QsM8vlvlXR4SODaaEaHONuzgnHIaqH/SsjfSq6Uw1F/Pdb93fV7I1XCLyqcWAdTIbmaYrnJ7G57J2wKjQ==';
        $fileClient = FileRestProxy::createFileService($connectionString);
        $fileClient2 = FileRestProxy::createFileService($connectionString2);
        $fileClient3 = FileRestProxy::createFileService($connectionString3);

        $shareName = 'users';
        $directoryName = $repoName;

        // Create directory.
        $fileClient->createDirectory($shareName, $directoryName);
        $fileClient2->createDirectory($shareName, $directoryName);
        $fileClient3->createDirectory($shareName, $directoryName);

        $repo = repository::create([
            'user_id' => $userid->id,
            'name' => $repoName,
            'dossierPrimaire' => 'Y',
            'cheminDossier' => $repoName,
            'dossierParent' => 'storage/',
            'publicLink' => ' '
        ]);

        $idCrypted = Crypt::encryptString($repo->id);

        $publicLink = 'http://localhost/SupDrive/public/'.'downloadRepoPublic/'.$idCrypted;

        repository::updatePublicLinkRepo($repo->id,$publicLink);

        stockage::create([
           'user_id' => $userid->id,
           'stockageUtilise' => 0
        ]);

        return $userid;

    }
}
