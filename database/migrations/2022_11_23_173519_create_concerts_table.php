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
        Schema::create('concerts', function (Blueprint $table) {
            $table->id();

            $table->string('nama_konser');
            $table->string('slug');
            $table->string('gambar');
            $table->string('deskripsi');
            $table->string('tanggal');
            $table->string('tempat');
            $table->string('harga');
            $table->string('status')->default('buka');


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concerts');
    }
};
