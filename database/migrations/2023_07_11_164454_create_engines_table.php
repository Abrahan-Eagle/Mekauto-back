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
        Schema::create('engines', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';

            //RELACIONES
            $table->unsignedBigInteger('car_model_id')->nullable();
            $table->foreign('car_model_id')->references('id')->on('car_models')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('engines');
    }
};
