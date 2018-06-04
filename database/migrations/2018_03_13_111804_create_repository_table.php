<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepositoryTable extends Migration
{

    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('dossierPrimaire');
            $table->string('cheminDossier');
            $table->string('dossierParent');
            $table->string('name');
            $table->string('publicLink');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('repositories');
    }
}
