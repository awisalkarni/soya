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
        // Remove client_id from sale_items
        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });

        // Add client_id to sales
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('client_id')->constrained('clients')->after('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Add client_id back to sale_items
        Schema::table('sale_items', function (Blueprint $table) {
            $table->foreignId('client_id')->constrained('clients');
        });

        // Remove client_id from sales
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
};
