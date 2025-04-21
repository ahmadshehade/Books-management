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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->unique();
            $table->string('slug')->unique(); // مفيد للرابط
            $table->string('author_name', 255);
            $table->text('description'); // بدل string
            $table->float('price', 10, 2)->default(0);
            $table->string('cover_image')->nullable(); // توضيح
            $table->string('isbn')->nullable();
            $table->date('published_at')->nullable();
            $table->integer('stock')->default(0);
            $table->string('language', 10)->default('en');
            $table->integer('pages')->nullable();
            $table->boolean('is_valid')->default(true);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
