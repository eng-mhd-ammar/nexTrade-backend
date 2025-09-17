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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('desk_ar');
            $table->string('name_en');
            $table->string('desk_en');
            $table->integer('count');
            $table->boolean('active')->default(true);
            $table->float('price');
            $table->smallInteger('discount');
            $table->string('image');
            $table->foreignId("category_id")->constrained("categories")->onDelete('cascade');
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
