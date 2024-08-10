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
        // Create clients table
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('walk in');
            $table->timestamps();
        });

        // Update sales table to include client_id
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('client_id')->default(1)->constrained('clients');
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
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });

        Schema::dropIfExists('clients');
    }
};
