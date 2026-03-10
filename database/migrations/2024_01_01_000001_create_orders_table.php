<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email');
            $table->enum('order_type', ['pickup','delivery']);
            $table->text('address')->nullable();
            $table->string('delivery_app')->nullable();
            $table->text('notes')->nullable();
            $table->json('items');
            $table->decimal('total', 10, 2);
            $table->enum('status', ['pending','confirmed','ready','completed','cancelled'])->default('pending');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};
