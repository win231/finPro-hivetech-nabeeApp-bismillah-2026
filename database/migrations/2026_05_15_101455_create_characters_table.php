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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('name');
            // Tipe/Level Evolusi (Larva, Lebah Pekerja, dll)
            $table->string('type')->default('Larva');
            // XP default-nya 0 saat karakter baru dibuat
            $table->integer('xp')->default(0);
            // Mood default-nya 'neutral'
            $table->string('current_mood')->default('neutral');
            // Tanggal terakhir menabung, pakai nullable() dulu 
            // jaga-jaga kalau pas baru bikin akun dia belum pernah nabung sama sekali
            $table->date('last_saved_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
