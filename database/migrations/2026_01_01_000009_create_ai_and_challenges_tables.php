<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // القواعد الذكية التي يضبطها الأدمن (FR-36)
        Schema::create('ai_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // اسم القاعدة
            $table->text('description')->nullable();
            $table->enum('rule_type', [
                'app_productivity_correlation', // ربط وقت التطبيقات بالإنتاجية (FR-16)
                'smart_reminder',               // تذكير ذكي (FR-13)
                'failure_pattern',              // نمط الفشل (FR-26)
                'habit_progression',            // التدرج في العادات
                'weekly_challenge_generator',   // توليد تحديات
            ]);
            // معاملات القاعدة - مثلاً معامل تأثير Instagram على الصلاة
            $table->json('parameters');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // التحديات الأسبوعية (FR-32)
        Schema::create('weekly_challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->date('week_start');  // بداية الأسبوع
            $table->date('week_end');    // نهاية الأسبوع

            // المهام المطلوبة (مقارنة الأسبوع الحالي بالماضي - FR-32)
            $table->json('targets'); // [{"activity_id":1,"target_value":7,"unit":"days"}]

            $table->enum('status', ['active', 'completed', 'failed'])->default('active');
            $table->unsignedSmallInteger('reward_points')->default(50);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'week_start']);
        });

        // إشعارات مخزنة محلياً ومُرسلة
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('body');
            $table->enum('type', [
                'reminder',          // تذكير نشاط
                'smart_reminder',    // تذكير ذكي مبني على AI
                'app_usage_warning', // تحذير تجاوز وقت التطبيقات (FR-17)
                'tip',               // نصيحة
                'achievement',       // إنجاز / شارة
                'challenge',         // تحدٍّ أسبوعي
            ]);
            $table->json('data')->nullable();   // بيانات إضافية
            $table->boolean('is_read')->default(false);
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('weekly_challenges');
        Schema::dropIfExists('ai_rules');
    }
};
