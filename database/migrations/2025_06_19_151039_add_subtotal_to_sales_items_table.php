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
    Schema::table('sales_items', function (Blueprint $table) {
        $table->decimal('subtotal', 10, 2)->after('price');
    });
}

public function down(): void
{
    Schema::table('sales_items', function (Blueprint $table) {
        $table->dropColumn('subtotal');
    });
}

};
