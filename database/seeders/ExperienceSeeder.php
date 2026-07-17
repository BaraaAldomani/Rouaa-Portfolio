<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'period_ar' => '2024 — حتى الآن',
                'period_en' => '2024 — Present',
                'role_ar' => 'شريك مؤسس',
                'role_en' => 'Co-Founder',
                'org_ar' => 'شركة ركيز — الرياض، السعودية',
                'org_en' => 'Rakeez Company — Riyadh, KSA',
                'description_ar' => 'المشاركة في تأسيس وبناء الشركة وتطوير خدماتها المالية والاستشارية.',
                'description_en' => 'Participating in founding and building the company and developing its financial and consulting services.',
                'sort_order' => 1,
            ],
            [
                'period_ar' => 'فبراير 2022 — حتى الآن',
                'period_en' => 'Feb 2022 — Present',
                'role_ar' => 'مدققة خارجية',
                'role_en' => 'External Auditor',
                'org_ar' => 'Embro CPA — الرياض، السعودية',
                'org_en' => 'Embro CPA — Riyadh, KSA',
                'description_ar' => 'تدقيق أكثر من 80 ملفاً عبر قطاعات المقاولات والصحة والبرمجيات والطاقة المتجددة والإعلان، وأبرز العملاء: أكبر مركز لعلاج السرطان في الشرق الأوسط.',
                'description_en' => 'Audited over 80 files across contracting, healthcare, software, renewable energy and advertising. Key clients include the largest cancer treatment center in the Middle East.',
                'sort_order' => 2,
            ],
            [
                'period_ar' => 'نوفمبر 2020 — فبراير 2022',
                'period_en' => 'Nov 2020 — Feb 2022',
                'role_ar' => 'أخصائية زكاة',
                'role_en' => 'Zakat Specialist',
                'org_ar' => 'Embro CPA — الرياض، السعودية',
                'org_en' => 'Embro CPA — Riyadh, KSA',
                'description_ar' => 'احتساب وتقديم إقرارات الزكاة لأكثر من 300 شركة ومثّلت أكثر من 17 شركة أمام هيئة الزكاة والضريبة والجمارك.',
                'description_en' => 'Calculated and submitted Zakat declarations for 300+ companies and represented 17+ companies before ZATCA.',
                'sort_order' => 3,
            ],
            [
                'period_ar' => 'فبراير 2020 — سبتمبر 2020',
                'period_en' => 'Feb 2020 — Sep 2020',
                'role_ar' => 'مدققة داخلية',
                'role_en' => 'Internal Auditor',
                'org_ar' => 'UTC ولطفي السلامات — دمشق، سوريا',
                'org_en' => 'UTC & Lutfi AlSalamat — Damascus, Syria',
                'description_ar' => 'تدقيق الدورة المستندية لشركة صناعية وجامعة خاصة.',
                'description_en' => 'Audited the documentary cycle of an industrial company and a private university.',
                'sort_order' => 4,
            ],
            [
                'period_ar' => 'سابقاً',
                'period_en' => 'Previously',
                'role_ar' => 'مدربة معتمدة',
                'role_en' => 'Certified Trainer',
                'org_ar' => 'LearningGo',
                'org_en' => 'LearningGo',
                'description_ar' => 'تقديم دورات تدريبية في المحاسبة والزكاة والتدقيق للمهنيين.',
                'description_en' => 'Delivering training courses in accounting, zakat and auditing for professionals.',
                'sort_order' => 5,
            ],
        ];

        foreach ($items as $item) {
            Experience::updateOrCreate(['sort_order' => $item['sort_order']], $item);
        }
    }
}
