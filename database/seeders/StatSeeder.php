<?php

namespace Database\Seeders;

use App\Models\Stat;
use Illuminate\Database\Seeder;

class StatSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            // Hero stats (4)
            ['context' => 'hero', 'value_display' => '+80', 'counter_target' => 80, 'label_ar' => 'ملف تدقيق', 'label_en' => 'Audit Files', 'sort_order' => 1],
            ['context' => 'hero', 'value_display' => '+300', 'counter_target' => 300, 'label_ar' => 'شركة احتساب زكاة', 'label_en' => 'Zakat Companies', 'sort_order' => 2],
            ['context' => 'hero', 'value_display' => '17+', 'counter_target' => 17, 'label_ar' => 'تمثيل أمام الهيئة', 'label_en' => 'ZATCA Representations', 'sort_order' => 3],
            ['context' => 'hero', 'value_display' => '6', 'counter_target' => 6, 'label_ar' => 'دراسات جدوى', 'label_en' => 'Feasibility Studies', 'sort_order' => 4],

            // Banner stats (5)
            ['context' => 'banner', 'value_display' => '+80', 'counter_target' => 80, 'label_ar' => 'ملف تدقيق في قطاعات متعددة', 'label_en' => 'Audit Files Across Sectors', 'sort_order' => 1],
            ['context' => 'banner', 'value_display' => '+300', 'counter_target' => 300, 'label_ar' => 'شركة تم احتساب زكاتها', 'label_en' => "Companies' Zakat Calculated", 'sort_order' => 2],
            ['context' => 'banner', 'value_display' => '17+', 'counter_target' => 17, 'label_ar' => 'شركة مُثّلت أمام هيئة الزكاة', 'label_en' => 'Companies Represented Before ZATCA', 'sort_order' => 3],
            ['context' => 'banner', 'value_display' => '6', 'counter_target' => 6, 'label_ar' => 'دراسات جدوى منجزة', 'label_en' => 'Feasibility Studies Completed', 'sort_order' => 4],
            ['context' => 'banner', 'value_display' => '1K+', 'counter_target' => 1000, 'label_ar' => 'متابع على يوتيوب', 'label_en' => 'YouTube Subscribers', 'sort_order' => 5],
        ];

        foreach ($stats as $stat) {
            Stat::updateOrCreate(
                ['context' => $stat['context'], 'sort_order' => $stat['sort_order']],
                $stat,
            );
        }
    }
}
