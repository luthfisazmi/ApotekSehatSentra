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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('buyer_name'); // Nama pembeli
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Produk yang dibeli
            $table->integer('quantity'); // Jumlah pembelian
            $table->decimal('total_price', 10, 2); // Total harga
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
