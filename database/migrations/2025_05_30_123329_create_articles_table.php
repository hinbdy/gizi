<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $table = 'articles';

   public function up()
{
    Schema::create('articles', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique(); // 👈 Tambahkan slug
        $table->text('content');
        $table->string('excerpt')->nullable(); // 👈 Tambahkan excerpt
        $table->string('category')->nullable(); // 👈 Tambahkan kategori
        $table->string('thumbnail')->nullable(); // 👈 Tambahkan thumbnail
        $table->boolean('published')->default(false);
        $table->unsignedInteger('views')->default(0); // 👈 Tambahkan views
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 👈 Penulis artikel
        $table->timestamps();
        $table->unsignedBigInteger('user_id'); 
        $table->unsignedBigInteger('category_id')->nullable();
    });
}

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
