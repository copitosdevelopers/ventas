<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('nombres',100);
            $table->string('apellidos',100);
            $table->string('tipo_documento',1);
            $table->string('nro_documento',15);
            $table->string('direccion',100)->nullable();
            $table->string('correo',100)->nullable();
            $table->string('telefono',15);
            $table->string('estado')->default(1);
            $table->string('usuario',20);
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
        Schema::dropIfExists('personas');
    }
}
