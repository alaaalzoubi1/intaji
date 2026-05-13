<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // سجل وقت استخدام تطبيقات الهاتف (FR-14, FR-15)
        Schema::create('app_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('app_package', 150); // مثل: com.instagram.android
            $table->string('app_name', 100);    // اسم للعرض: Instagram
            $table->enum('app_category', [
                'social',       // تواصل اجتماعي
                'entertainment',// ترفيه
                'games',        // ألعاب
                'productivity', // إنتاجية
                'education',    // تعليم
                'other',
            ])->default('other');

            $table->date('usage_date');
            $table->unsignedInteger('duration_minutes'); // إجمالي الوقت بالدقائق

            $table->timestamps();

            $table->unique(['user_id', 'app_package', 'usage_date']);
            $table->index(['user_id', 'usage_date']);
        });

        // حدود التطبيقات التي يضبطها المستخدم (FR-17)
        Schema::create('app_usage_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('app_package', 150)->nullable(); // null = حد عام لكل التطبيقات الترفيهية
            $table->unsignedSmallInteger('daily_limit_minutes')->default(180); // 3 ساعات افتراضياً
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'app_package']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_usage_limits');
        Schema::dropIfExists('app_usage_logs');
    }
};
