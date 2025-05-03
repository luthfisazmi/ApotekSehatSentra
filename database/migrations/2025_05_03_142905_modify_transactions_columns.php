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
        Schema::table('transactions', function (Blueprint $table) {
            // Mengubah kolom untuk tidak boleh NULL
            $table->string('name')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->integer('quantity')->nullable(false)->change();
            $table->decimal('sub_payment', 15, 2)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Jika rollback, mengembalikan kolom-kolom menjadi nullable
            $table->string('name')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->integer('quantity')->nullable()->change();
            $table->decimal('sub_payment', 15, 2)->nullable()->change();
        });
    }
};
