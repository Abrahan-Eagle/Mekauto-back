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
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->string('slug')-> unique();
            $table->mediumText('excerpt')->nullable();
            $table->text('content')->nullable();

            $table->bigInteger('stock');
            $table->decimal('price', 10, 2);

            $table->enum('status', ['PUBLISHED', 'DRAFT' ])->default('DRAFT');

            $table->enum('level', ['top_sales', 'new_products', 'most_seen', 'nothing' ])->default('nothing');
            $table->enum('advertising', [0, 1])->default(0);

            $table->string('img', 128)->nullable();
            $table->string('url_video')->nullable();

            $table->timestamps();
            $table->engine = 'InnoDB';

            //Relation
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
