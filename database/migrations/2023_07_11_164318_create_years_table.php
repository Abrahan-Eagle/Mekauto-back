<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('years', function (Blueprint $table) {
            $table->bigIncrements('id');


            $table->bigInteger('years');

            $table->timestamps();
            $table->engine = 'InnoDB';

            //RELACIONES
            $table->unsignedBigInteger('mark_id')->nullable();
            $table->foreign('mark_id')->references('id')->on('marks')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('years');
    }
};
