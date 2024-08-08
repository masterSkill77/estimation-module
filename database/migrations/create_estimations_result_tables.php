<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('estimation_results', function (Blueprint $table) {
            $table->id();
            $table->date("fidji_date_mutation");
            $table->integer("fidji_no_disposition");
            $table->integer("fidji_valeur_fonciere");
            $table->integer("fidji_nature_mutation");
            $table->string("l_fidji_nature_mutation");
            $table->string("majic_insee");
            $table->boolean("sogefi_parcelle_terrain");
            $table->boolean("sogefi_autre_parcelle_terrain");
            $table->boolean("sogefi_parcelle_local");
            $table->boolean("sogefi_autre_parcelle_local");
            $table->boolean("sogefi_parcelle_lot");
            $table->boolean("sogefi_autre_parcelle_lot");
            $table->boolean("sogefi_multipolygone");
            $table->unsignedBigInteger("estimation_id");
            $table->timestamps();
        });
    }
};
