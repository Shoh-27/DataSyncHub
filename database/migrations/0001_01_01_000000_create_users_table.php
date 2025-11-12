<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->enum('role', ['client', 'freelancer', 'moderator', 'admin'])->default('freelancer');
            $table->enum('account_status', ['active', 'suspended', 'deactivated'])->default('active');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar_url')->nullable();
            $table->text('bio')->nullable();
            $table->string('timezone')->default('UTC');
            $table->string('language')->default('en');
            $table->json('skills')->nullable(); // Array of skill IDs
            $table->enum('profile_visibility', ['public', 'connections', 'private'])->default('public');
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index('email');
            $table->index('role');
            $table->index('account_status');
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->dropIfExists('users');
    }
};
