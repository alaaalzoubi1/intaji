<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // الأقسام - يديرها الأدمن (FR-33)
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // اسم القسم (مثل: العبادات)
            $table->string('name_en')->nullable(); // اسم بالإنجليزية (اختياري)
            $table->text('description')->nullable();
            $table->string('icon')->nullable();     // أيقونة القسم
            $table->string('color', 20)->nullable(); // لون مميز لكل قسم
            $table->unsignedSmallInteger('order')->default(0); // ترتيب العرض
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
