<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['label_ar' => 'Excel & Power BI', 'label_en' => 'Excel & Power BI', 'sort_order' => 1],
            ['label_ar' => 'إنشاء محتوى', 'label_en' => 'Content Creation', 'sort_order' => 2],
            ['label_ar' => 'التدريب المؤسسي', 'label_en' => 'Corporate Training', 'sort_order' => 3],
            ['label_ar' => 'حل المشكلات', 'label_en' => 'Problem Solving', 'sort_order' => 4],
            ['label_ar' => 'التحدث أمام الجمهور', 'label_en' => 'Public Speaking', 'sort_order' => 5],
            ['label_ar' => 'ريادة الأعمال', 'label_en' => 'Entrepreneurship', 'sort_order' => 6],
        ];

        foreach ($items as $item) {
            Skill::updateOrCreate(['sort_order' => $item['sort_order']], $item);
        }
    }
}
