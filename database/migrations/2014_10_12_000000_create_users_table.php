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
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            //LOCAL
            $table->string('name');
            $table->string('profile_pic')->default('person_1.jpg');
            $table->timestamp('email_verified_at')->nullable();
            //LOCAL Y GOOGLE
            //$table->string('AccessToken')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            //GOOGLE
            //$table->bigInteger('idGoogleUser')->nullable();
            $table->string('idToken')->nullable();
            $table->string('familyName')->nullable();
            $table->string('givenName')->nullable();
            $table->string('imageUrl')->nullable();
            //INFO SYSTEM
            $table->rememberToken();
            $table->timestamps();

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            // Agregar columna para la relación
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
