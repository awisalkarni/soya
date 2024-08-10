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
        // Create companies table
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Create payment methods table
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('method');
            $table->timestamps();
        });

        // Create products table
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });

        // Create sales table
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->integer('quantity');
            $table->decimal('price', 8, 2)->nullable(); // Nullable to allow price override
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
        Schema::dropIfExists('sales');
        Schema::dropIfExists('products');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('companies');
    }
};
