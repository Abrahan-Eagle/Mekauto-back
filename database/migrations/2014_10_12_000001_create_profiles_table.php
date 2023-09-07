<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->year('birth_date');
            $table->enum('status', ['completeData', 'incompleteData', 'notverified' ])->default('notverified');
            $table->enum('role', ['nothing','buyer', 'seller', 'both', 'carrier', 'admin'])->default('nothing');
            $table->enum('score', ['0', '1', '2', '3', '4', '5'])->default('0');
            $table->timestamps();



            // Agregar columna para la relación
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            /*$table->unsignedBigInteger('cell_phone_id')->nullable();
            $table->foreign('cell_phone_id')->references('id')->on('cell_phones')->onDelete('cascade')->onUpdate('cascade');
            */

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
