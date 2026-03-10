<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // cookies, brownies, cookie-cakes, boxes
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('unit')->default('per pc'); // per pc, per box, whole
            $table->string('tag')->nullable(); // Bestseller, New, etc.
            $table->string('image')->nullable(); // path to uploaded image
            $table->boolean('available')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
