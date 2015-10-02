<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultimidiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multimidia', function (Blueprint $table) {
            $table->increments('id_multimidia');
            $table->integer('id_midia')->unsigned();
            $table->string('descricao')->nullable();
            $table->string('video')->nullable();
            $table->string('link')->nullable();
            $table->string('imagem')->nullable();
            $table->integer('ordem')->nullable();
            $table->integer('status')->default(1);
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
        Schema::drop('multimidia');
    }
}
