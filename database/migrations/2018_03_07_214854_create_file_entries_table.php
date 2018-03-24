<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileEntriesTable extends Migration
{

    public function up()
    {
        Schema::create('file_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('name');
            $table->string('cheminFichier');
            $table->string('dossierStockage');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('file_entries');
    }
}
