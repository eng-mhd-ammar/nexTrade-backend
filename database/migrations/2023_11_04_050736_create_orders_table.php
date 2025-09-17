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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users")->onDelete('cascade');
            $table->foreignId("address_id")->nullable()->constrained("addresses")->onDelete('cascade')->default(null);
            $table->string('receive_type')->default('drive_thru');
            $table->string('payment_type')->default('cash');
            $table->double('shipping')->default(0);
            $table->double('price')->default(0);
            $table->double('total_price')->default(0);
            $table->foreignId('coupon_id')->nullable()->constrained("coupons")->onDelete('cascade')->default(null);
            $table->tinyInteger('status')->default(0);
            $table->foreignId("delivery_id")->nullable()->constrained("users")->onDelete('cascade')->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
