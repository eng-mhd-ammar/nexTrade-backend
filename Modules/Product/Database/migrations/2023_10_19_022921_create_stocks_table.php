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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('desc_ar');
            $table->string('name_en');
            $table->string('desc_en');
            $table->double('price')->nullable();
            $table->integer('quantity')->default(-1);
            $table->double('weight')->default(0);
            $table->string('sku')->nullable()/*->unique()*/;
            $table->json('images');
            $table->json('attributes');
            $table->foreignId('product_id')->nullable()->constrained('products', 'id')->onDelete('cascade')->onUpdate('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
