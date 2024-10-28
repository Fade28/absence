<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_Diganti');
            $table->foreign('id_Diganti')->references('id')->on('gurus');
            $table->date('Tanggal');
            $table->unsignedBigInteger('id_Mengganti');
            $table->foreign('id_Mengganti')->references('id')->on('gurus');
            $table->string('Jenis_Potongan');
            $table->integer('Jumlah_Potongan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
