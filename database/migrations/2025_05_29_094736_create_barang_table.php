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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('nama');
            $table->text('detail');
            $table->integer('harga');
            $table->foreignId('id_jenis')->nullable()->constrained('jenis_barang')->onDelete('set null');
            $table->foreignId('id_satuan')->nullable()->constrained('satuan')->onDelete('set null');
            $table->boolean('is_rekomendasi')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
