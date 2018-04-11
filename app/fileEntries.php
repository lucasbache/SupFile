<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fileEntries extends Model
{
    protected $fillable = ['user_id', 'name', 'cheminFichier', 'dossierStockage',];
}
