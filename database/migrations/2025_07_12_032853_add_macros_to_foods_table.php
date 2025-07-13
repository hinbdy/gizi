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
        Schema::table('foods', function (Blueprint $table) {
            // Menambahkan 3 kolom baru setelah kolom 'calories'
            // Tipe data 'decimal' bagus untuk angka desimal, (8, 2) artinya total 8 digit dengan 2 digit di belakang koma.
            $table->decimal('carbs', 8, 2)->after('calories')->default(0);   // Karbohidrat dalam gram
            $table->decimal('protein', 8, 2)->after('carbs')->default(0);     // Protein dalam gram
            $table->decimal('fat', 8, 2)->after('protein')->default(0);      // Lemak dalam gram
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foods', function (Blueprint $table) {
            // Ini untuk jaga-jaga jika Anda perlu membatalkan migration
            $table->dropColumn(['carbs', 'protein', 'fat']);
        });
    }
};