# إنتاجي – منتِج | Laravel Backend

## هيكل المشروع

```
database/migrations/
├── 2026_01_01_000001_create_users_table.php
├── 2026_01_01_000002_create_sections_table.php
├── 2026_01_01_000003_create_activities_table.php
├── 2026_01_01_000004_create_user_activity_settings_table.php
├── 2026_01_01_000005_create_activity_logs_table.php
├── 2026_01_01_000006_create_app_usage_tables.php
├── 2026_01_01_000007_create_tips_tables.php
├── 2026_01_01_000008_create_gamification_tables.php
└── 2026_01_01_000009_create_ai_and_challenges_tables.php

app/Models/
├── User.php
├── Section.php
├── Activity.php
├── ActivityLog.php          (+ UserActivitySetting, AppUsageLog, AppUsageLimit)
├── Tip.php                  (+ TipFeedback, UserTipHistory)
├── Badge.php                (+ UserPoints, PointTransaction, ProductivityTree, StoreItem, UserStorePurchase)
└── AiRule.php               (+ WeeklyChallenge, AppNotification)

database/migrations/DatabaseSeeder.php  ← انقله إلى database/seeders/
```

## خطوات الإعداد

```bash
# 1. إنشاء مشروع Laravel
composer create-project laravel/laravel intaji
cd intaji

# 2. نسخ ملفات المايجريشنز والموديلز

# 3. إعداد .env
cp .env.example .env
# DB_DATABASE=intaji_db
# DB_USERNAME=root
# DB_PASSWORD=...

# 4. تشغيل المايجريشنز والـ Seeder
php artisan migrate --seed

# 5. تثبيت Sanctum للـ API Authentication
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

## خريطة الجداول

| الجدول | الغرض | المتطلب |
|--------|--------|---------|
| `users` | حسابات المستخدمين + إعدادات الشخصية | FR-01 إلى FR-05 |
| `sections` | الأقسام التسعة (يديرها الأدمن) | FR-33 |
| `activities` | الأنشطة مع طرق القياس الثماني | FR-33, FR-34 |
| `user_activity_settings` | تذكيرات مخصصة لكل مستخدم | FR-11 |
| `activity_logs` | تسجيلات الأنشطة اليومية | FR-06 إلى FR-10 |
| `app_usage_logs` | وقت استخدام تطبيقات الهاتف | FR-14, FR-15 |
| `app_usage_limits` | الحدود اليومية للتطبيقات | FR-17 |
| `tips` | قاعدة النصائح (ثابتة + شرطية) | FR-35 |
| `tip_feedbacks` | تقييم المستخدم للنصائح | FR-26 |
| `user_tip_history` | تاريخ النصائح المعروضة | FR-27 |
| `badges` | الشارات المتاحة | FR-29 |
| `user_badges` | الشارات المكتسبة | FR-29 |
| `user_points` | رصيد النقاط | FR-28 |
| `point_transactions` | حركة النقاط | FR-28 |
| `productivity_trees` | الشجرة الافتراضية | FR-30 |
| `store_items` | عناصر المتجر | FR-31 |
| `user_store_purchases` | مشتريات المستخدمين | FR-31 |
| `ai_rules` | قواعد الذكاء الاصطناعي | FR-36 |
| `weekly_challenges` | التحديات الأسبوعية | FR-32 |
| `notifications` | الإشعارات | FR-12, FR-13 |

## الخطوات التالية

- [ ] Routes API (routes/api.php)
- [ ] Controllers (AuthController, ActivityController, StatsController, AdminController)
- [ ] Form Requests (Validation)
- [ ] API Resources (Transformers)
- [ ] Services (AiTipService, AppUsageAnalyzer, PointsService)
- [ ] Scheduled Commands (daily tree decay, weekly challenge generator)
- [ ] Firebase FCM للإشعارات
