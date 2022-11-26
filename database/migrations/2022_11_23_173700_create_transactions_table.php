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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('concert_id');
            $table->foreign('concert_id')->references('id')->on('concerts')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('kode_transaksi');
            $table->string('nama_pembeli');
            $table->string('email_pembeli');
            $table->string('no_hp_pembeli');
            $table->string('jumlah_tiket');
            $table->string('biaya_servis');
            $table->string('total_harga');
            $table->string('status_transaksi');

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
        Schema::dropIfExists('transactions');
    }
};
