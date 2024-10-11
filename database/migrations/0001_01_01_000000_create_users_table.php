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
        Schema::create('users', function (Blueprint $table) {
            $table->id();  // bigint unsigned auto_increment
            $table->string('prefixname')->nullable();  // varchar(255)
            $table->string('firstname');  // varchar(255)
            $table->string('middlename')->nullable();  // varchar(255)
            $table->string('lastname');  // varchar(255)
            $table->string('suffixname')->nullable();  // varchar(255)
            $table->string('username')->unique();  // varchar(255), unique
            $table->string('email')->unique();  // varchar(255), unique
            $table->text('password');  // text
            $table->text('photo')->nullable();  // text
            $table->string('type')->default('user');  // varchar(255), default to 'user'
            $table->rememberToken();  // varchar(100) (for the remember_token)
            $table->timestamp('email_verified_at')->nullable();  // timestamp
            $table->timestamps();  // created_at and updated_at
            $table->softDeletes();  // deleted_at for soft deletion

            // Indexes
            $table->index('type');  // MUL (index) on 'type'
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
