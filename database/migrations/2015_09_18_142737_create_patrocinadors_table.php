<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatrocinadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patrocinador', function (Blueprint $table) {
            $table->increments('id_patrocinador');
            $table->string('nome');
            $table->string('link')->nullable();
            $table->longText('logo')->nullable();
            $table->string('ordem')->nullable();
            $table->string('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('patrocinador');
    }
}
