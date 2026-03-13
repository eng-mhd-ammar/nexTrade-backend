<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Auth\Enums\UserType;
use Modules\Auth\Enums\Gender;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->boolean('gender')->default(Gender::MALE->value)->comment(Gender::tableComment());
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_type_id')->default(UserType::USER->value)->comment(UserType::tableComment())->constrained("user_types")->onDelete('cascade');

            $table->string('verification_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
