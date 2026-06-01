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
        Schema::create('surat_jalan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_jalan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pengajuan_sparepart_id')->constrained();
            $table->foreignId('sparepart_id')->constrained();
            $table->integer('quantity');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_jalan_details');
    }
};
