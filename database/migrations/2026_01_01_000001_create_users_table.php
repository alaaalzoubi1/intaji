<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->boolean('is_admin')->default(false);

            // Personality test results (FR-05)
            $table->enum('chronotype', ['morning', 'evening', 'neutral'])->default('neutral'); // صباحي/مسائي
            $table->enum('activity_preference', ['short', 'long', 'mixed'])->default('mixed'); // تفضيل الأنشطة
            $table->json('main_goals')->nullable(); // الأهداف الرئيسية (مصفوفة أقسام)

            // Settings
            $table->boolean('dark_mode')->default(false);
            $table->string('language', 10)->default('ar');
            $table->boolean('notifications_enabled')->default(true);

            // Privacy (NFR-03)
            $table->boolean('app_tracking_enabled')->default(false); // إذن تتبع وقت التطبيقات

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
