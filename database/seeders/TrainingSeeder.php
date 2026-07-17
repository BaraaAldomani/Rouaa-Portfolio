<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\TrainingSeries;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    public function run(): void
    {
        $series = [
            [
                'title_ar' => 'سلسلة المحاسبة العملية',
                'title_en' => 'Practical Accounting Series',
                'tag_ar' => 'من الصفر إلى الاحتراف',
                'tag_en' => 'From Zero to Professional',
                'sort_order' => 1,
                'courses' => [
                    [
                        'icon' => '📘',
                        'title_ar' => 'المحاسبة من الصفر — المفاهيم الأساسية',
                        'title_en' => 'Accounting from Scratch — Core Concepts',
                        'description_ar' => 'القيود المحاسبية، دليل الحسابات، المعادلة المحاسبية وأنواع الحسابات — للمبتدئين تماماً',
                        'description_en' => 'Journal entries, chart of accounts, accounting equation and account types — for absolute beginners',
                        'level' => 'beginner',
                    ],
                    [
                        'icon' => '📗',
                        'title_ar' => 'إعداد القوائم المالية',
                        'title_en' => 'Preparing Financial Statements',
                        'description_ar' => 'قائمة المركز المالي، قائمة الدخل، التدفقات النقدية — كيف تقرأها وتُعدّها',
                        'description_en' => 'Balance sheet, income statement, cash flows — how to read and prepare them',
                        'level' => 'intermediate',
                    ],
                    [
                        'icon' => '📙',
                        'title_ar' => 'مسك الدفاتر بالتطبيق العملي',
                        'title_en' => 'Bookkeeping in Practice',
                        'description_ar' => 'تطبيق عملي كامل على دورة محاسبية حقيقية من البداية حتى إغلاق الميزانية',
                        'description_en' => 'Full practical application on a real accounting cycle from start to balance sheet closing',
                        'level' => 'intermediate',
                    ],
                ],
            ],
            [
                'title_ar' => 'سلسلة الزكاة والضريبة',
                'title_en' => 'Zakat & Tax Series',
                'tag_ar' => 'الأنظمة والتطبيق',
                'tag_en' => 'Regulations & Application',
                'sort_order' => 2,
                'courses' => [
                    [
                        'icon' => '🕌',
                        'title_ar' => 'أساسيات الزكاة في المملكة',
                        'title_en' => 'Zakat Fundamentals in Saudi Arabia',
                        'description_ar' => 'مفهوم الوعاء الزكوي، طريقة الاحتساب، والفرق بين أنواع الشركات — تأسيس نظري متين',
                        'description_en' => 'Zakat base concept, calculation method, and difference between company types — solid theoretical foundation',
                        'level' => 'beginner',
                    ],
                    [
                        'icon' => '📋',
                        'title_ar' => 'تقديم الإقرار الزكوي عملياً',
                        'title_en' => 'Filing the Zakat Declaration in Practice',
                        'description_ar' => 'خطوات تقديم الإقرار عبر بوابة هيئة الزكاة، المواعيد، المستندات المطلوبة والأخطاء الشائعة',
                        'description_en' => 'Steps to file declarations via the ZATCA portal, deadlines, required documents and common mistakes',
                        'level' => 'intermediate',
                    ],
                    [
                        'icon' => '⚖️',
                        'title_ar' => 'نظام 2216 والتحديثات الضريبية',
                        'title_en' => 'Regulation 2216 & Tax Updates',
                        'description_ar' => 'التعامل مع النظام الجديد، الاعتراضات أمام اللجان الضريبية، وأبرز التحديثات التنظيمية',
                        'description_en' => 'Working with the new regulation, objections before tax committees, and key regulatory updates',
                        'level' => 'advanced',
                    ],
                ],
            ],
            [
                'title_ar' => 'سلسلة التدقيق المهني',
                'title_en' => 'Professional Auditing Series',
                'tag_ar' => 'المفاهيم والممارسة',
                'tag_en' => 'Concepts & Practice',
                'sort_order' => 3,
                'courses' => [
                    [
                        'icon' => '🔍',
                        'title_ar' => 'مدخل إلى التدقيق الداخلي والخارجي',
                        'title_en' => 'Introduction to Internal & External Auditing',
                        'description_ar' => 'الفرق بين التدقيق الداخلي والخارجي، أهداف التدقيق، والمعايير الدولية للمراجعة',
                        'description_en' => 'Difference between internal and external auditing, audit objectives, and international auditing standards',
                        'level' => 'beginner',
                    ],
                    [
                        'icon' => '📂',
                        'title_ar' => 'الدورة المستندية وملف التدقيق',
                        'title_en' => 'Documentary Cycle & Audit File',
                        'description_ar' => 'كيف تُعدّ ملف التدقيق، تقييم الرقابة الداخلية، واختبارات المعاملات',
                        'description_en' => 'How to prepare an audit file, evaluate internal controls, and perform transaction testing',
                        'level' => 'intermediate',
                    ],
                    [
                        'icon' => '📝',
                        'title_ar' => 'تقرير المدقق وحالات عملية',
                        'title_en' => "Auditor's Report & Practical Cases",
                        'description_ar' => 'أنواع تقارير المدقق، دراسة حالات حقيقية من قطاعات متعددة، وإعداد التقرير النهائي',
                        'description_en' => 'Types of auditor reports, real case studies from multiple sectors, and preparing the final report',
                        'level' => 'advanced',
                    ],
                ],
            ],
            [
                'title_ar' => 'سلسلة دراسات الجدوى والتحليل المالي',
                'title_en' => 'Feasibility Studies & Financial Analysis Series',
                'tag_ar' => 'قرر بثقة',
                'tag_en' => 'Decide with Confidence',
                'sort_order' => 4,
                'courses' => [
                    [
                        'icon' => '💡',
                        'title_ar' => 'مكونات دراسة الجدوى',
                        'title_en' => 'Components of a Feasibility Study',
                        'description_ar' => 'الدراسة السوقية والتقنية والمالية والتنظيمية — كيف تبني دراسة جدوى متكاملة من الصفر',
                        'description_en' => 'Market, technical, financial and organizational study — how to build a complete feasibility study from scratch',
                        'level' => 'beginner',
                    ],
                    [
                        'icon' => '📈',
                        'title_ar' => 'التحليل المالي للمشاريع',
                        'title_en' => 'Financial Analysis for Projects',
                        'description_ar' => 'صافي القيمة الحالية NPV، معدل العائد الداخلي IRR، فترة الاسترداد — بأمثلة حقيقية',
                        'description_en' => 'NPV, IRR, payback period — with real examples',
                        'level' => 'intermediate',
                    ],
                    [
                        'icon' => '🏙️',
                        'title_ar' => 'تحليل حالة عملية كاملة',
                        'title_en' => 'Full Practical Case Analysis',
                        'description_ar' => 'تطبيق كامل على دراسة جدوى حقيقية من السوق السعودي خطوة بخطوة مع النقاشات التفاعلية',
                        'description_en' => 'Full application on a real feasibility study from the Saudi market step by step with interactive discussions',
                        'level' => 'advanced',
                    ],
                ],
            ],
        ];

        foreach ($series as $data) {
            $courses = $data['courses'];
            unset($data['courses']);

            $model = TrainingSeries::updateOrCreate(['title_en' => $data['title_en']], $data);

            foreach ($courses as $i => $course) {
                $course['training_series_id'] = $model->id;
                $course['sort_order'] = $i + 1;
                Course::updateOrCreate(
                    ['training_series_id' => $model->id, 'title_en' => $course['title_en']],
                    $course,
                );
            }
        }
    }
}
