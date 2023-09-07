<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void


    {
        Schema::create('cell_phones', function (Blueprint $table) {
            $table->id();
            $table->string('cell_phone_number')->nullable();
            $table->enum('primary_phone_number', ['primary', 'second'])->default('second');
            $table->timestamp('cell_phone_verified_at')->nullable();
            $table->enum('status', ['0', '1'])->default('0');

            // otros campos de la tabla cell_phone

            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');

            $table->timestamps();
            //$table->engine = 'InnoDB';
        });
/*
        Schema::table('cell_phones', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        */

    }




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cell_phones');
    }
};
