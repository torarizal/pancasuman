<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penulis artikel
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Rubrik utama
            $table->foreignId('series_id')->nullable()->constrained()->onDelete('set null'); // Opsional jika bagian dari series/cerpen bersambung
            $table->integer('volume_number')->nullable(); // Nomor urut volume (jika masuk series)
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Ringkasan singkat untuk pratinjau
            $table->longText('body'); // Isi utama artikel / cerpen
            $table->string('featured_image')->nullable(); // Gambar sampul artikel
            $table->enum('status', ['draft', 'published'])->default('draft'); // Status tulisan
            $table->timestamp('published_at')->nullable(); // Waktu terbit
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};