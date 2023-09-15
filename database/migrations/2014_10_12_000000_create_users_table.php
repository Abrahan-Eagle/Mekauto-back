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
            $table->enum('email_verified', ['true', 'false'])->default('false');
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
