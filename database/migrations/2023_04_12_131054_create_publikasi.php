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
        Schema::create('publikasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('sub_judul')->nullable();
            $table->string('image')->nullable();
            $table->string('slug')->unique();
            $table->unsignedSmallInteger('kategori')->nullable();
            $table->string('status')->nullable();
            $table->unsignedSmallInteger('tipe')->nullable();
            $table->text('isi');
            $table->string('penulis')->nullable();
            $table->string('pengedit')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publikasi');
    }
};
