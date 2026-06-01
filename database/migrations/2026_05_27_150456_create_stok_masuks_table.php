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
        Schema::create('stok_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sparepart_id')->constrained('spareparts')->cascadeOnDelete();
            $table->integer('quantity');
            $table->date('tanggal_masuk');
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_masuks');
    }
};
