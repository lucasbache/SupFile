<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class repository extends Model
{
    protected $fillable = ['user_id', 'name', 'dossierPrimaire', 'cheminDossier', 'dossierParent'];
}
