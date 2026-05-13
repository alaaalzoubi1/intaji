<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // قاعدة النصائح (FR-35, FR-36 - يديرها الأدمن)
        Schema::create('tips', function (Blueprint $table) {
            $table->id();
            $table->text('content');          // نص النصيحة
            $table->enum('type', [
                'static',       // ثابتة - تُعرض دائماً
                'conditional',  // شرطية - تُعرض عند تحقق شرط
                'ai_generated', // مولّدة بالذكاء الاصطناعي
            ])->default('static');

            // الشرط (للنصائح الشرطية) - مثل: "activity_commitment < 0.5"
            // يُخزن كـ JSON يحتوي على: metric, operator, value, activity_id (اختياري)
            $table->json('condition')->nullable();

            // ربط النصيحة بقسم أو نشاط معين (اختياري)
            $table->foreignId('section_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained()->nullOnDelete();

            $table->enum('tip_category', [
                'time_analysis',      // تحليل الوقت المثالي
                'failure_analysis',   // تحليل سبب الفشل
                'habit_gradual',      // التدرج في العادات
                'psychological',      // الدعم النفسي
                'predictive',         // تنبؤية
                'app_usage_related',  // مرتبطة بوقت التطبيقات
                'weekly_challenge',   // تحديات أسبوعية
                'general',
            ])->default('general');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // تقييمات المستخدمين للنصائح (FR-26)
        Schema::create('tip_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tip_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_helpful'); // مفيدة أم لا
            $table->timestamp('shown_at');
            $table->timestamps();

            $table->unique(['user_id', 'tip_id']);
        });

        // النصائح المعروضة للمستخدم (لتجنب التكرار + FR-27)
        Schema::create('user_tip_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tip_id')->nullable()->constrained()->nullOnDelete();
            $table->text('ai_tip_content')->nullable(); // نصيحة مولّدة من AI لا تُخزن في tips
            $table->date('shown_date');
            $table->timestamps();

            $table->index(['user_id', 'shown_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_tip_history');
        Schema::dropIfExists('tip_feedbacks');
        Schema::dropIfExists('tips');
    }
};
