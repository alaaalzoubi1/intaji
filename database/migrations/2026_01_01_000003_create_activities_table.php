<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // الأنشطة - يديرها الأدمن (FR-33, FR-34)
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->string('name');                  // اسم النشاط
            $table->text('description')->nullable();
            $table->string('icon')->nullable();

            // طريقة القياس (قسم 3.3)
            $table->enum('measurement_type', [
                'yes_no',       // نعم/لا
                'pages',        // عدد الصفحات
                'minutes',      // عدد الدقائق/الساعات
                'count',        // عدد المرات
                'percentage',   // نسبة مئوية 0-100
                'rating',       // تقييم 1-5
                'text',         // نص حر قصير
                'timer',        // مؤقت مدمج (بومودورو)
            ])->default('yes_no');

            $table->string('unit', 50)->nullable(); // وحدة القياس (صفحة، دقيقة، كوب، دينار...)
            $table->unsignedSmallInteger('points')->default(10); // الوزن/النقاط (FR-28)

            // أيام التكرار
            $table->enum('repeat_type', ['daily', 'specific_days', 'odd_days', 'even_days'])->default('daily');
            $table->json('specific_days')->nullable(); // [0,1,2,3,4,5,6] - الأحد=0 للسبت=6

            // وقت التذكير الافتراضي (يمكن للمستخدم تعديله)
            $table->time('default_reminder_time')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
