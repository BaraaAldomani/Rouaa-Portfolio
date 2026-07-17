<?php

namespace Database\Seeders;

use App\Models\EducationItem;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'institution_ar' => 'Plymouth Marjon University',
                'institution_en' => 'Plymouth Marjon University',
                'detail_ar' => 'ماجستير إدارة أعمال MBA — قيد التنفيذ',
                'detail_en' => 'MBA — In Progress',
                'sort_order' => 1,
            ],
            [
                'institution_ar' => 'جامعة دمشق',
                'institution_en' => 'Damascus University',
                'detail_ar' => 'بكالوريوس اقتصاد — الأولى على الدفعة 2020',
                'detail_en' => 'Bachelor of Economics — Top of Class 2020',
                'sort_order' => 2,
            ],
            [
                'institution_ar' => 'IVORY Training & Consulting',
                'institution_en' => 'IVORY Training & Consulting',
                'detail_ar' => 'مدرب مؤسسي معتمد TOT — 2022',
                'detail_en' => 'Professional Corporate Trainer TOT — 2022',
                'sort_order' => 3,
            ],
            [
                'institution_ar' => 'AlTanmiya للتعليم والتطوير',
                'institution_en' => 'AlTanmiya Education & Development',
                'detail_ar' => 'دبلوم دراسات الجدوى • دبلوم التحليل المالي المتقدم • دورة CMA • التخطيط بعيد المدى',
                'detail_en' => 'Feasibility Studies • Advanced Financial Analysis • CMA • Long-term Planning',
                'sort_order' => 4,
            ],
            [
                'institution_ar' => 'مركز دمشق للدراسات الاقتصادية',
                'institution_en' => 'Damascus Center for Economic Studies',
                'detail_ar' => 'دورة الاقتصاد العصبي — 2020',
                'detail_en' => 'Neuroeconomics Course — 2020',
                'sort_order' => 5,
            ],
            [
                'institution_ar' => 'معهد أسس',
                'institution_en' => 'Osos Institute',
                'detail_ar' => 'دبلوم إدارة الأعمال — 2017',
                'detail_en' => 'Diploma in Business Administration — 2017',
                'sort_order' => 6,
            ],
        ];

        foreach ($items as $item) {
            EducationItem::updateOrCreate(['sort_order' => $item['sort_order']], $item);
        }
    }
}
