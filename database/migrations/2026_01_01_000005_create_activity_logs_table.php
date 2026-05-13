<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // تسجيلات الأنشطة اليومية (FR-06, FR-07, FR-08)
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();

            $table->date('log_date');   // تاريخ التسجيل

            // القيمة حسب نوع القياس
            $table->boolean('value_bool')->nullable();        // yes_no
            $table->decimal('value_numeric', 10, 2)->nullable(); // pages, minutes, count, percentage
            $table->unsignedTinyInteger('value_rating')->nullable(); // rating 1-5
            $table->text('value_text')->nullable();           // text / نص حر
            $table->unsignedInteger('value_seconds')->nullable(); // timer - مدة المؤقت بالثواني

            // مدخل الإدخال
            $table->enum('input_method', ['manual', 'voice', 'camera', 'quick_tap'])->default('manual'); // FR-06, FR-09, FR-10

            // سبب عدم الإنجاز إذا كان "لا" (FR-26 + قسم 3.8)
            $table->enum('failure_reason', [
                'forgot',       // نسيت
                'lazy',         // كسل
                'busy',         // انشغال
                'tired',        // تعب
                'phone_distraction', // إلهاء بالجوال
                'other',
            ])->nullable();
            $table->string('failure_reason_note', 255)->nullable(); // تفاصيل إضافية

            $table->string('note', 500)->nullable(); // ملاحظة حرة للتسجيل
            $table->string('evidence_image')->nullable(); // صورة دليل (FR-10)

            // تتبع التعديلات (FR-07)
            $table->timestamp('edited_at')->nullable();
            $table->text('edit_history')->nullable(); // JSON - تاريخ التعديلات السابقة

            $table->timestamps();

            // مفتاح فريد: مستخدم + نشاط + يوم
            $table->unique(['user_id', 'activity_id', 'log_date']);
            $table->index(['user_id', 'log_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
