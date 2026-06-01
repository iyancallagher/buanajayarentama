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
        Schema::create('pengajuan_spareparts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('sparepart_id')->constrained();
            $table->integer('requested_quantity')->nullable();
            $table->integer('approved_quantity')->nullable();
            $table->enum('status',[
                'menunggu',
                'disetujui',
                'ditolak',
            ])->default('menunggu');
            $table->text('keterangan')->nullable();
            $table->json('foto')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_spareparts');
    }
};
