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
        Schema::create('favorites_songs',function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_song');
            $table->unsignedBigInteger('id_account');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->foreign('id_song')->references('id')->on('song')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_account')->references('id')->on('account')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites_songs');
    }
};
