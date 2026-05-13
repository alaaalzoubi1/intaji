<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // إعدادات كل مستخدم لكل نشاط (تذكيرات مخصصة، تفعيل/تعطيل)
        Schema::create('user_activity_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();

            $table->boolean('is_enabled')->default(true); // هل المستخدم فعّل هذا النشاط
            $table->time('reminder_time')->nullable();     // وقت تذكير مخصص (FR-11)
            $table->boolean('smart_reminder')->default(false); // تذكير ذكي يتعلم من الأنماط (FR-11)
            $table->boolean('notifications_enabled')->default(true); // إيقاف إشعارات هذا النشاط (FR-12)

            $table->timestamps();
            $table->unique(['user_id', 'activity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_activity_settings');
    }
};
