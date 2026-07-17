<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'key' => 'bookkeeping',
                'icon' => '📒',
                'title_ar' => 'مسك الدفاتر',
                'title_en' => 'Bookkeeping',
                'summary_ar' => 'إعداد وتنظيم السجلات المحاسبية والقوائم المالية باحترافية',
                'summary_en' => 'Prepare and organize accounting records and financial statements professionally',
                'description_ar' => 'أقدم خدمة مسك الدفاتر المحاسبية الاحترافية للشركات والمنشآت بدءاً من إعداد دليل الحسابات وتصنيف العمليات المالية وصولاً إلى إعداد القوائم المالية الدورية، مما يمنحك رؤية واضحة لوضعك المالي في أي وقت.',
                'description_en' => 'I provide professional bookkeeping services for businesses, from setting up the chart of accounts and classifying financial transactions to preparing periodic financial statements, giving you a clear picture of your financial position at any time.',
                'features_ar' => ['دليل الحسابات', 'القيود المحاسبية', 'القوائم المالية', 'التسوية الشهرية'],
                'features_en' => ['Chart of Accounts', 'Journal Entries', 'Financial Statements', 'Monthly Reconciliation'],
                'legal_note_ar' => null,
                'legal_note_en' => null,
                'sort_order' => 1,
            ],
            [
                'key' => 'zakat_tax',
                'icon' => '🏛️',
                'title_ar' => 'الاستشارات الزكوية والضريبية',
                'title_en' => 'Zakat & Tax Advisory',
                'summary_ar' => 'احتساب الزكاة وتقديم الإقرارات وتمثيل الشركات أمام الهيئة',
                'summary_en' => 'Zakat calculation, filing declarations and representing companies before ZATCA',
                'description_ar' => 'بخبرة شملت أكثر من 300 شركة في احتساب الزكاة، وتمثيل أكثر من 17 شركة أمام هيئة الزكاة والضريبة والجمارك، أقدم استشارات دقيقة تساعد منشأتك على الامتثال الكامل للأنظمة المعتمدة.',
                'description_en' => 'With experience covering Zakat calculation for over 300 companies and representing more than 17 companies before ZATCA, I provide precise advisory services that help your business achieve full regulatory compliance.',
                'features_ar' => ['احتساب الزكاة', 'تقديم الإقرارات', 'نظام 2216', 'شركات مدرجة وقابضة'],
                'features_en' => ['Zakat Calculation', 'Filing Declarations', 'Regulation 2216', 'Listed & Holding Companies'],
                'legal_note_ar' => 'تُقدَّم خدمات التمثيل أمام الهيئة وفق الضوابط النظامية المعتمدة في المملكة العربية السعودية.',
                'legal_note_en' => 'Representation services before the authority are provided in accordance with approved regulatory requirements in Saudi Arabia.',
                'sort_order' => 2,
            ],
            [
                'key' => 'feasibility',
                'icon' => '📊',
                'title_ar' => 'دراسات الجدوى',
                'title_en' => 'Feasibility Studies',
                'summary_ar' => 'دراسات اقتصادية شاملة لمساعدتك على اتخاذ قرارات استثمارية صحيحة',
                'summary_en' => 'Comprehensive economic studies to help you make sound investment decisions',
                'description_ar' => 'أعدّ دراسات جدوى اقتصادية شاملة بناءً على 6 دراسات منجزة في قطاعات متنوعة. تشمل الدراسة التحليل السوقي والدراسة التقنية والتحليل المالي التفصيلي وتقييم المخاطر لتمكينك من اتخاذ قرار استثماري مدروس.',
                'description_en' => 'I prepare comprehensive economic feasibility studies based on 6 completed studies across various sectors. Studies include market analysis, technical study, detailed financial analysis and risk assessment to enable informed investment decisions.',
                'features_ar' => ['التحليل السوقي', 'الجدوى المالية', 'تقييم المخاطر', 'التحليل التنافسي', 'خطة العمل'],
                'features_en' => ['Market Analysis', 'Financial Viability', 'Risk Assessment', 'Competitive Analysis', 'Business Plan'],
                'legal_note_ar' => null,
                'legal_note_en' => null,
                'sort_order' => 3,
            ],
            [
                'key' => 'training',
                'icon' => '🎓',
                'title_ar' => 'التدريب المهني والمؤسسي',
                'title_en' => 'Professional & Corporate Training',
                'summary_ar' => 'دورات متخصصة في المحاسبة والتدقيق والزكاة لتطوير الكفاءات المهنية',
                'summary_en' => 'Specialized courses in accounting, auditing and zakat to develop professional competencies',
                'description_ar' => 'بحكم خبرتي الميدانية وحصولي على شهادة مدرب مؤسسي معتمد TOT، أقدم برامج تدريبية متخصصة للأفراد والشركات في مجالات المحاسبة والزكاة والضريبة والتدقيق. سبق وتعاونت مع شركة LearningGo في تقديم برامج تدريبية محكمة.',
                'description_en' => 'Leveraging my field experience and TOT certification, I deliver specialized training programs for individuals and companies in accounting, zakat, tax and auditing. I previously collaborated with LearningGo in delivering structured training programs.',
                'features_ar' => ['دورات محاسبة', 'دورات زكاة وضريبة', 'دورات تدقيق', 'تدريب مؤسسي', 'TOT معتمدة'],
                'features_en' => ['Accounting Courses', 'Zakat & Tax Courses', 'Auditing Courses', 'Corporate Training', 'TOT Certified'],
                'legal_note_ar' => null,
                'legal_note_en' => null,
                'sort_order' => 4,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['key' => $service['key']], $service);
        }
    }
}
