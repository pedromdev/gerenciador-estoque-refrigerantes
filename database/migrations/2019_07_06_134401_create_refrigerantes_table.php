<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefrigerantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refrigerantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('marca_id')->nullable(false);
            $table->float('litragem')->unsigned()->nullable(false);
            $table->enum('tipo', [
                'Pet',
                'Garrafa',
                'Lata'
            ])->nullable(false);
            $table->integer('quantidade')->unsigned()->default(0);
            $table->float('valor_unitario')->unsigned()->nullable(false);
            $table->foreign('marca_id')
                ->references('id')
                ->on('marcas')
                ->onDelete('cascade');
            $table->unique([ 'marca_id', 'litragem' ]);
            $table->softDeletes();
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
        Schema::dropIfExists('refrigerantes');
    }
}
