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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->after('price');
        });
        
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE products MODIFY COLUMN type ENUM('game', 'pc', 'console') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE products MODIFY COLUMN type ENUM('game', 'pc') NOT NULL");

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
};
