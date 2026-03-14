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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('desc_ar');
            $table->string('name_en');
            $table->string('desc_en');
            $table->json('meta');
            $table->boolean('is_active')->default(true);
            $table->string('mpn')->nullable()/*->unique()*/;
            $table->string('gtin')->nullable()/*->unique()*/;
            $table->string('oem')->nullable()/*->unique()*/;
            $table->text('note')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories', 'id')->onDelete('set null')->onUpdate('cascade');

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
