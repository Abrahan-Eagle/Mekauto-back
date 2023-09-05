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
            $table->engine = 'InnoDB';

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
