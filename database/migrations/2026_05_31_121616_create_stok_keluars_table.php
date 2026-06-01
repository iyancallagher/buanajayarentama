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
        Schema::create('stok_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_jalan_id')->constrained('surat_jalans')->cascadeOnDelete();
            $table->foreignId('sparepart_id')->constrained('spareparts')->cascadeOnDelete();
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_keluars');
    }
};
