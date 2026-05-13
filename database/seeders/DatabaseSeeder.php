<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Activity;
use App\Models\Tip;
use App\Models\Badge;
use App\Models\StoreItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===================== الأدمن =====================
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@intaji.app',
            'password' => Hash::make('Admin@2026!'),
            'is_admin' => true,
        ]);

        // ===================== الأقسام التسعة =====================
        $sections = [
            ['name' => 'العبادات',              'name_en' => 'Worship',       'icon' => 'mosque',      'color' => '#4CAF50', 'order' => 1],
            ['name' => 'الصحة واللياقة',         'name_en' => 'Health',        'icon' => 'heart',       'color' => '#F44336', 'order' => 2],
            ['name' => 'التعلم والمعرفة',        'name_en' => 'Learning',      'icon' => 'book',        'color' => '#2196F3', 'order' => 3],
            ['name' => 'العمل والإنتاجية',       'name_en' => 'Work',          'icon' => 'briefcase',   'color' => '#FF9800', 'order' => 4],
            ['name' => 'المالي والاقتصادي',      'name_en' => 'Finance',       'icon' => 'wallet',      'color' => '#795548', 'order' => 5],
            ['name' => 'الاجتماعي والأسري',      'name_en' => 'Social',        'icon' => 'users',       'color' => '#9C27B0', 'order' => 6],
            ['name' => 'النفسي والروحي',         'name_en' => 'Mental',        'icon' => 'brain',       'color' => '#607D8B', 'order' => 7],
            ['name' => 'الإبداعي والمهاري',      'name_en' => 'Creative',      'icon' => 'palette',     'color' => '#E91E63', 'order' => 8],
            ['name' => 'البيئي والاستدامة',      'name_en' => 'Environment',   'icon' => 'leaf',        'color' => '#8BC34A', 'order' => 9],
        ];

        foreach ($sections as $sectionData) {
            Section::create($sectionData);
        }

        // ===================== الأنشطة الأساسية =====================
        $activities = [
            // العبادات (id=1)
            ['section_id' => 1, 'name' => 'صلاة الفجر',   'measurement_type' => 'yes_no',  'points' => 30, 'default_reminder_time' => '05:00:00', 'order' => 1],
            ['section_id' => 1, 'name' => 'صلاة الظهر',   'measurement_type' => 'yes_no',  'points' => 20, 'default_reminder_time' => '12:30:00', 'order' => 2],
            ['section_id' => 1, 'name' => 'صلاة العصر',   'measurement_type' => 'yes_no',  'points' => 20, 'default_reminder_time' => '15:30:00', 'order' => 3],
            ['section_id' => 1, 'name' => 'صلاة المغرب',  'measurement_type' => 'yes_no',  'points' => 20, 'default_reminder_time' => '18:30:00', 'order' => 4],
            ['section_id' => 1, 'name' => 'صلاة العشاء',  'measurement_type' => 'yes_no',  'points' => 20, 'default_reminder_time' => '20:00:00', 'order' => 5],
            ['section_id' => 1, 'name' => 'قراءة القرآن', 'measurement_type' => 'pages',   'unit' => 'صفحة', 'points' => 25, 'default_reminder_time' => '21:00:00', 'order' => 6],
            ['section_id' => 1, 'name' => 'الأذكار الصباحية', 'measurement_type' => 'yes_no', 'points' => 15, 'default_reminder_time' => '07:00:00', 'order' => 7],
            ['section_id' => 1, 'name' => 'الأذكار المسائية', 'measurement_type' => 'yes_no', 'points' => 15, 'default_reminder_time' => '17:30:00', 'order' => 8],

            // الصحة (id=2)
            ['section_id' => 2, 'name' => 'شرب الماء',     'measurement_type' => 'count',   'unit' => 'كوب',  'points' => 10, 'order' => 1],
            ['section_id' => 2, 'name' => 'ممارسة الرياضة','measurement_type' => 'minutes',  'unit' => 'دقيقة','points' => 20, 'order' => 2],
            ['section_id' => 2, 'name' => 'النوم المبكر',  'measurement_type' => 'yes_no',   'points' => 15, 'default_reminder_time' => '22:30:00', 'order' => 3],
            ['section_id' => 2, 'name' => 'تناول وجبة صحية','measurement_type' => 'count', 'unit' => 'وجبة', 'points' => 10, 'order' => 4],

            // التعلم (id=3)
            ['section_id' => 3, 'name' => 'القراءة',       'measurement_type' => 'pages',   'unit' => 'صفحة',  'points' => 15, 'order' => 1],
            ['section_id' => 3, 'name' => 'تعلم مهارة جديدة','measurement_type' => 'minutes','unit' => 'دقيقة','points' => 20, 'order' => 2],
            ['section_id' => 3, 'name' => 'مراجعة الدراسة','measurement_type' => 'minutes', 'unit' => 'دقيقة', 'points' => 15, 'order' => 3],

            // العمل (id=4)
            ['section_id' => 4, 'name' => 'العمل المركز (بومودورو)', 'measurement_type' => 'timer', 'unit' => 'جلسة', 'points' => 25, 'order' => 1],
            ['section_id' => 4, 'name' => 'إنجاز المهام المخططة', 'measurement_type' => 'percentage', 'unit' => '%', 'points' => 20, 'order' => 2],

            // المالي (id=5)
            ['section_id' => 5, 'name' => 'تسجيل المصاريف', 'measurement_type' => 'yes_no', 'points' => 10, 'order' => 1],
            ['section_id' => 5, 'name' => 'الادخار اليومي', 'measurement_type' => 'count', 'unit' => 'دينار', 'points' => 15, 'order' => 2],

            // الاجتماعي (id=6)
            ['section_id' => 6, 'name' => 'صلة الرحم',    'measurement_type' => 'yes_no', 'points' => 20, 'repeat_type' => 'specific_days', 'specific_days' => [5,6], 'order' => 1],
            ['section_id' => 6, 'name' => 'مساعدة شخص',   'measurement_type' => 'count',  'unit' => 'مرة', 'points' => 15, 'order' => 2],

            // النفسي (id=7)
            ['section_id' => 7, 'name' => 'التأمل',        'measurement_type' => 'minutes', 'unit' => 'دقيقة', 'points' => 15, 'order' => 1],
            ['section_id' => 7, 'name' => 'كتابة المشاعر', 'measurement_type' => 'text',    'points' => 10, 'order' => 2],
            ['section_id' => 7, 'name' => 'تقييم مزاجك اليوم', 'measurement_type' => 'rating', 'points' => 5, 'order' => 3],

            // الإبداعي (id=8)
            ['section_id' => 8, 'name' => 'الكتابة الإبداعية', 'measurement_type' => 'minutes', 'unit' => 'دقيقة', 'points' => 15, 'order' => 1],
            ['section_id' => 8, 'name' => 'تعلم مهارة يدوية', 'measurement_type' => 'minutes', 'unit' => 'دقيقة', 'points' => 15, 'order' => 2],

            // البيئي (id=9)
            ['section_id' => 9, 'name' => 'تقليل استهلاك البلاستيك', 'measurement_type' => 'yes_no', 'points' => 10, 'order' => 1],
            ['section_id' => 9, 'name' => 'إعادة التدوير', 'measurement_type' => 'yes_no', 'points' => 10, 'order' => 2],
        ];

        foreach ($activities as $activityData) {
            $activityData['specific_days'] ??= null;
            $activityData['repeat_type']   ??= 'daily';
            $activityData['unit']          ??= null;
            $activityData['description']   ??= null;
            $activityData['default_reminder_time'] ??= null;
            Activity::create($activityData);
        }

        // ===================== الشارات =====================
        $badges = [
            ['name' => 'مواظب على الفجر',  'icon' => 'badge_fajr',    'unlock_condition' => ['type' => 'streak', 'activity_id' => 1, 'days' => 7],  'points_reward' => 100],
            ['name' => 'الرياضي الحديدي',  'icon' => 'badge_sport',   'unlock_condition' => ['type' => 'streak', 'activity_id' => 10, 'days' => 14], 'points_reward' => 150],
            ['name' => 'منخفض الجوال',     'icon' => 'badge_nophone', 'unlock_condition' => ['type' => 'app_usage', 'max_minutes' => 60, 'days' => 7], 'points_reward' => 200],
            ['name' => 'قارئ القرآن',      'icon' => 'badge_quran',   'unlock_condition' => ['type' => 'total', 'activity_id' => 6, 'total_pages' => 604], 'points_reward' => 500],
            ['name' => 'شارب الماء',       'icon' => 'badge_water',   'unlock_condition' => ['type' => 'daily_target', 'activity_id' => 9, 'target' => 8, 'days' => 7], 'points_reward' => 80],
        ];

        foreach ($badges as $badge) Badge::create($badge);

        // ===================== نصائح ثابتة =====================
        $tips = [
            ['content' => 'ابدأ يومك بنية صادقة وابتسامة. الإنتاجية الحقيقية تبدأ من الداخل.', 'type' => 'static', 'tip_category' => 'general'],
            ['content' => 'حاول ربط عادة جديدة بعادة قائمة. مثلاً: اشرب كوب ماء مباشرة بعد كل صلاة.', 'type' => 'static', 'tip_category' => 'habit_gradual'],
            ['content' => 'قسّم أهدافك الكبيرة إلى خطوات صغيرة يومية. الخطوة الصغيرة المنتظمة تتفوق دائماً على الجهد المتقطع.', 'type' => 'static', 'tip_category' => 'habit_gradual'],

            // نصائح شرطية
            [
                'content'      => 'لاحظنا أن التزامك بصلاة الفجر منخفض هذا الأسبوع. حاول تحديد وقت نومك مبكراً بـ 30 دقيقة.',
                'type'         => 'conditional',
                'tip_category' => 'failure_analysis',
                'condition'    => ['metric' => 'activity_commitment', 'activity_id' => 1, 'operator' => '<', 'value' => 0.5],
                'activity_id'  => 1,
            ],
            [
                'content'      => 'وقت استخدامك للتطبيقات الترفيهية تجاوز 3 ساعات اليوم. هذا قد يؤثر على إنتاجيتك وجودة نومك.',
                'type'         => 'conditional',
                'tip_category' => 'app_usage_related',
                'condition'    => ['metric' => 'entertainment_minutes', 'operator' => '>', 'value' => 180],
            ],
        ];

        foreach ($tips as $tip) Tip::create($tip);

        // ===================== عناصر المتجر =====================
        $storeItems = [
            ['name' => 'خلفية الغروب',       'type' => 'background', 'asset_path' => 'store/bg_sunset.jpg',   'price_points' => 100],
            ['name' => 'خلفية الصحراء',       'type' => 'background', 'asset_path' => 'store/bg_desert.jpg',  'price_points' => 150],
            ['name' => 'أيقونة نجمة ذهبية',  'type' => 'icon',       'asset_path' => 'store/icon_star.png',  'price_points' => 50],
            ['name' => 'صوت تشجيع عربي',     'type' => 'sound',      'asset_path' => 'store/sound_arabic.mp3','price_points' => 80],
            ['name' => 'شجرة الساكورا',       'type' => 'tree_skin',  'asset_path' => 'store/tree_sakura.png','price_points' => 300],
        ];

        foreach ($storeItems as $item) StoreItem::create($item);
    }
}
