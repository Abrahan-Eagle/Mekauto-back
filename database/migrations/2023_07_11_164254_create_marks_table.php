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
        Schema::create('marks', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('name')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';

            //RELACIONES
            $table->unsignedBigInteger('vehicle_types_id')->nullable();
            $table->foreign('vehicle_types_id')->references('id')->on('vehicle_types')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marks');
    }
};
