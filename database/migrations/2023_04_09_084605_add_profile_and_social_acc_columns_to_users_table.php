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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')
                ->after('name')
                ->nullable(false);
            $table->string('picture')
                ->after('email')
                ->nullable();
            $table->enum('role', ['administrator', 'editor', 'author'])
                ->after('email_verified_at')
                ->default('author');
            $table->dateTime('last_logged_in_at')
                ->nullable();
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->string('www')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->boolean('default')->default(0);

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'picture', 'role', 'last_logged_in_at', 'phone', 'bio', 'www', 'facebook', 'twitter', 'tiktok', 'instagram', 'youtube']);
            $table->dropSoftDeletes();
        });
    }
};
