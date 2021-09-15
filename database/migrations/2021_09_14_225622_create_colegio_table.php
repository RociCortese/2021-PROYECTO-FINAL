<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColegioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colegio', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono');
            $table->bigInteger('files_id')->unsigned();
            $table->foreign('files_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colegio');
    }
}
