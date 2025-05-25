<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('daftar_keuangan', function (Blueprint $table) {
            $table->id();
            $table->float('pemasukan')->nullable();
            $table->float('pengeluaran')->nullable();
            $table->unsignedBigInteger('kategori_id'); // Foreign key harus unsigned
            $table->date('tanggal');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        
            $table->foreign('kategori_id')->references('id')->on('categories')->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_keuangan');
    }
};
