<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // الشارات المتاحة في التطبيق (FR-29)
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');            // مثل: مواظب على الفجر
            $table->text('description')->nullable();
            $table->string('icon');            // مسار الأيقونة
            $table->json('unlock_condition');  // {"type":"streak","activity_id":1,"days":7}
            $table->unsignedSmallInteger('points_reward')->default(0); // نقاط عند الفتح
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // الشارات المكتسبة من قبل المستخدمين
        Schema::create('user_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('badge_id')->constrained()->cascadeOnDelete();
            $table->timestamp('earned_at');
            $table->timestamps();

            $table->unique(['user_id', 'badge_id']);
        });

        // محفظة نقاط المستخدم (FR-28)
        Schema::create('user_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('total_points')->default(0);
            $table->unsignedInteger('available_points')->default(0); // بعد خصم ما أُنفق في المتجر
            $table->timestamps();

            $table->unique('user_id');
        });

        // سجل حركة النقاط
        Schema::create('point_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('amount');          // موجب = مكسب، سالب = إنفاق
            $table->enum('reason', [
                'activity_completed', // إنجاز نشاط
                'badge_earned',       // شارة مكتسبة
                'store_purchase',     // شراء من المتجر (FR-31)
                'streak_bonus',       // مكافأة الاستمرارية
                'challenge_won',      // إنجاز تحدٍّ
            ]);
            $table->morphs('source'); // رابط للمصدر (activity_log, badge, إلخ)
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });

        // شجرة الإنتاجية الافتراضية (FR-30)
        Schema::create('productivity_trees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('health')->default(100); // 0-100 (تتضاءل مع الإهمال)
            $table->unsignedTinyInteger('level')->default(1);    // مستوى نمو الشجرة
            $table->unsignedInteger('total_water')->default(0);  // وحدات العناية التراكمية
            $table->timestamp('last_watered_at')->nullable();
            $table->timestamps();

            $table->unique('user_id');
        });

        // المتجر الصغير (FR-31)
        Schema::create('store_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['background', 'icon', 'sound', 'tree_skin']);
            $table->string('asset_path');
            $table->unsignedSmallInteger('price_points');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('user_store_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('store_item_id')->constrained()->cascadeOnDelete();
            $table->timestamp('purchased_at');
            $table->boolean('is_active')->default(false); // هل هو المُفعَّل حالياً

            $table->unique(['user_id', 'store_item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_store_purchases');
        Schema::dropIfExists('store_items');
        Schema::dropIfExists('productivity_trees');
        Schema::dropIfExists('point_transactions');
        Schema::dropIfExists('user_points');
        Schema::dropIfExists('user_badges');
        Schema::dropIfExists('badges');
    }
};
