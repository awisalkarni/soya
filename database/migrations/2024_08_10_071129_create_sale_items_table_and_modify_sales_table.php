<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Modify the sales table
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['client_id']);
            $table->dropColumn(['product_id', 'client_id', 'quantity', 'price']);
        });

        // Create sale_items table
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('client_id')->constrained('clients');
            $table->integer('quantity');
            $table->decimal('unit_price', 8, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('client_id')->constrained('clients');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
        });

        Schema::dropIfExists('sale_items');
    }
};
