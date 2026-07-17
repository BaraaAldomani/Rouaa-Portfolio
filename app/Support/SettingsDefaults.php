<?php

namespace App\Support;

/**
 * Single source of truth for every dashboard-managed *setting* default,
 * grouped exactly like the Filament settings pages. Values are seeded into
 * the settings table by SettingsSeeder and used as form fallbacks by the
 * SettingsPage subclasses (each delegates its defaultValues() here). All copy
 * is taken verbatim from the source design so a fresh install is fully
 * populated in both locales.
 *
 * Multi-paragraph fields (about.story_*, training.intro_*) store paragraphs
 * separated by a blank line; templates split on /\n\n+/.
 */
final class SettingsDefaults
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            'theme' => self::theme(),
            'identity' => self::identity(),
            'home' => self::home(),
            'pages' => self::pages(),
            'about' => self::about(),
            'training' => self::training(),
            'contact' => self::contact(),
            'seo' => self::seo(),
            'images' => self::images(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function group(string $group): array
    {
        return self::all()[$group] ?? [];
    }

    /** @return array<string, mixed> */
    public static function theme(): array
    {
        return [
            'primary' => '#1B9BD2',   // sky blue — brand mark
            'secondary' => '#16384C', // deep blue-slate — ink & dark sections
            'accent' => '#35C3EE',    // bright sky highlight
        ];
    }

    /** @return array<string, mixed> */
    public static function identity(): array
    {
        return [
            'name_ar' => 'رؤى محمود',
            'name_en' => 'Rouaa Mahmoud',
            'eyebrow_ar' => 'مستشارة أعمال • شريك مؤسس شركة ركيز • الرياض، السعودية',
            'eyebrow_en' => 'Business Consultant • Co-Founder at Rakeez • Riyadh, Saudi Arabia',
            'tagline_ar' => 'انطلق من حيث أنت',
            'tagline_en' => 'Start From Where You Are',
            'cta_primary_ar' => 'استكشف الخدمات',
            'cta_primary_en' => 'Explore Services',
            'cta_secondary_ar' => 'الدورات التدريبية',
            'cta_secondary_en' => 'Training Courses',
        ];
    }

    /** @return array<string, mixed> */
    public static function home(): array
    {
        return [
            'strip_tag_ar' => 'ما أقدمه',
            'strip_tag_en' => 'What I Offer',
            'strip_title_ar' => 'خدمات متخصصة في المالية والأعمال',
            'strip_title_en' => 'Specialized Financial & Business Services',
            'services_cta_ar' => 'استكشف جميع الخدمات',
            'services_cta_en' => 'Explore all services',
        ];
    }

    /** @return array<string, mixed> */
    public static function pages(): array
    {
        return [
            'about_title_ar' => 'من أنا',
            'about_title_en' => 'About Me',
            'about_lead_ar' => 'محاسبة، مدققة، مدربة، وشريك مؤسس — مسيرة مبنية على الخبرة الحقيقية',
            'about_lead_en' => 'Accountant, Auditor, Trainer & Co-Founder — A career built on real experience',

            'services_title_ar' => 'خدماتي',
            'services_title_en' => 'My Services',
            'services_lead_ar' => 'خدمات مالية واستشارية متكاملة مبنية على خبرة ميدانية حقيقية',
            'services_lead_en' => 'Comprehensive financial and consulting services built on real field experience',

            'training_title_ar' => 'الدورات التدريبية',
            'training_title_en' => 'Training Courses',
            'training_lead_ar' => 'سلاسل تدريبية متخصصة في المحاسبة والزكاة والضريبة والتدقيق — مبنية على خبرة ميدانية حقيقية',
            'training_lead_en' => 'Specialized training series in accounting, Zakat, tax and auditing — built on real field experience',

            'contact_title_ar' => 'تواصل معي',
            'contact_title_en' => 'Get in Touch',
            'contact_lead_ar' => 'هل لديك مشروع، استفسار، أو ترغب في الاستفسار عن التدريب؟ أنا هنا للمساعدة.',
            'contact_lead_en' => 'Have a project, inquiry, or interested in training? I am here to help.',
        ];
    }

    /** @return array<string, mixed> */
    public static function about(): array
    {
        return [
            'story_heading_ar' => 'قصتي المهنية',
            'story_heading_en' => 'My Professional Story',
            'story_ar' => implode("\n\n", [
                'مدققة خارجية وأخصائية زكاة، دققت أكثر من 80 ملفاً وعملت على احتساب الزكاة لأكثر من 300 شركة وفق الأنظمة القديمة والجديدة، ومثّلت أكثر من 17 شركة أمام هيئة الزكاة والضريبة والجمارك مباشرة.',
                'تخرجت أولى على دفعتي من جامعة دمشق — كلية الاقتصاد، وأواصل الآن دراستي للحصول على درجة الماجستير في إدارة الأعمال MBA من Plymouth Marjon University.',
                'إلى جانب العمل الاستشاري، أنا مدربة معتمدة (TOT) وأقدم برامج تدريبية في المحاسبة والزكاة والضريبة والتدقيق، سبق وتعاونت مع شركة LearningGo في تقديم التدريب.',
            ]),
            'story_en' => implode("\n\n", [
                'An external auditor and Zakat specialist who audited over 80 files, worked on calculating Zakat for more than 300 companies under old and new regulations, and represented over 17 companies before ZATCA.',
                'I graduated first in my class from Damascus University — Faculty of Economics, and I am currently pursuing an MBA from Plymouth Marjon University.',
                'Alongside consulting, I am a certified trainer (TOT) delivering training programs in accounting, Zakat, tax and auditing. I previously collaborated with LearningGo in delivering training.',
            ]),
            'rakeez_title_ar' => 'شريك مؤسس — شركة ركيز',
            'rakeez_title_en' => 'Co-Founder — Rakeez Company',
            'rakeez_text_ar' => 'مساهمة في بناء مستقبل الأعمال المالية',
            'rakeez_text_en' => 'Contributing to building the future of financial business',
            'career_heading_ar' => 'المسيرة المهنية',
            'career_heading_en' => 'Career Journey',
            'education_eyebrow_ar' => 'التعليم والشهادات',
            'education_eyebrow_en' => 'Education',
            'education_title_ar' => 'المسيرة التعليمية',
            'education_title_en' => 'Academic Journey',
        ];
    }

    /** @return array<string, mixed> */
    public static function training(): array
    {
        return [
            'intro_heading_ar' => 'لماذا التدريب مع رؤى؟',
            'intro_heading_en' => 'Why Train with Rouaa?',
            'intro_ar' => implode("\n\n", [
                'ما يميز تدريبي أنه ينبع من الميدان مباشرة. كل مفهوم أقدمه هو مفهوم طبّقته في الواقع — سواء في قاعات المراجعة، أو أمام هيئة الزكاة، أو في تحليل المشاريع. لن تسمع هنا نظرية مجردة.',
                'أنا مدربة مؤسسية معتمدة TOT، وسبق تعاوني مع شركة LearningGo في تقديم برامج تدريبية منظمة ومحكمة. أقدم التدريب بأسلوب تفاعلي يجمع بين الشرح والتطبيق والأمثلة الحقيقية.',
            ]),
            'intro_en' => implode("\n\n", [
                'What sets my training apart is that it comes directly from the field. Every concept I teach is one I have applied in practice — whether in audit rooms, before ZATCA, or in project analysis. You won\'t hear abstract theory here.',
                'I am a certified corporate trainer TOT, and I previously collaborated with LearningGo in delivering organized and structured training programs. I train in an interactive style that combines explanation, application and real examples.',
            ]),
            'partner_heading_ar' => 'خبرة تدريبية معتمدة',
            'partner_heading_en' => 'Certified Training Experience',
            'partner_cert' => 'TOT Certified',
            'partner_collab_pre_ar' => 'تعاون سابق مع',
            'partner_collab_pre_en' => 'Previous collaboration with',
            'partner_name' => 'LearningGo',
            'partner_collab_post_ar' => 'في تقديم البرامج التدريبية التخصصية',
            'partner_collab_post_en' => 'in delivering specialized training programs',
            'cta_heading_ar' => 'هل أنت مهتم بالتدريب؟',
            'cta_heading_en' => 'Interested in Training?',
            'cta_text_ar' => 'تواصل معي للاستفسار عن الدورات المتاحة أو لتصميم برنامج تدريبي مخصص لمنشأتك',
            'cta_text_en' => 'Contact me to inquire about available courses or to design a customized training program for your organization',
            'cta_button_ar' => 'تواصل للتسجيل',
            'cta_button_en' => 'Contact to Enroll',
        ];
    }

    /** @return array<string, mixed> */
    public static function contact(): array
    {
        return [
            'email' => 'D1rouaa@gmail.com',
            'phone_display' => '+966 533 63 2669',
            'whatsapp' => '966533632669',
            'location_ar' => 'الرياض، المملكة العربية السعودية',
            'location_en' => 'Riyadh, Saudi Arabia',
            'linkedin' => 'https://www.linkedin.com/in/rouaa-mahmoud',
            'youtube_url' => 'https://www.youtube.com/@RouaaMahmoud',
            'youtube_label_ar' => 'يوتيوب (~1K متابع)',
            'youtube_label_en' => 'YouTube (~1K Subscribers)',
            'social_heading_ar' => 'تابعيني على منصاتي',
            'social_heading_en' => 'Follow Me on My Platforms',
            // Global "have a question" CTA — reused on the services page footer band.
            'cta_heading_ar' => 'هل لديك استفسار؟',
            'cta_heading_en' => 'Have a Question?',
            'cta_text_ar' => 'تواصل معي وسأكون سعيدة بمساعدتك في اختيار الخدمة المناسبة لاحتياجاتك',
            'cta_text_en' => 'Contact me and I will be happy to help you choose the right service for your needs',
            'cta_button_ar' => 'تواصل معي الآن',
            'cta_button_en' => 'Contact Me Now',
        ];
    }

    /** @return array<string, mixed> */
    public static function seo(): array
    {
        return [
            'home_title_ar' => 'رؤى محمود | استشارات مالية وزكوية وتدريب مهني',
            'home_title_en' => 'Rouaa Mahmoud | Financial & Zakat Consulting & Professional Training',
            'home_description_ar' => 'رؤى محمود — استشارية أعمال ومدققة خارجية وأخصائية زكاة ومدربة معتمدة. مسك دفاتر، استشارات زكوية وضريبية، دراسات جدوى، وتدريب مهني في الرياض.',
            'home_description_en' => 'Rouaa Mahmoud — business consultant, external auditor, Zakat specialist and certified trainer. Bookkeeping, Zakat & tax advisory, feasibility studies and professional training in Riyadh.',

            'about_title_ar' => 'من أنا | رؤى محمود',
            'about_title_en' => 'About | Rouaa Mahmoud',
            'about_description_ar' => 'تعرّف على مسيرة رؤى محمود: مدققة خارجية وأخصائية زكاة وشريك مؤسس في شركة ركيز، مع خبرة في تدقيق أكثر من 80 ملفاً واحتساب زكاة 300+ شركة.',
            'about_description_en' => "Rouaa Mahmoud's professional journey: external auditor, Zakat specialist and Rakeez co-founder, with 80+ audit files and Zakat calculation for 300+ companies.",

            'services_title_ar' => 'خدماتي | رؤى محمود',
            'services_title_en' => 'Services | Rouaa Mahmoud',
            'services_description_ar' => 'خدمات مالية واستشارية: مسك الدفاتر، الاستشارات الزكوية والضريبية، دراسات الجدوى، والتدريب المهني والمؤسسي.',
            'services_description_en' => 'Financial and consulting services: bookkeeping, Zakat & tax advisory, feasibility studies, and professional & corporate training.',

            'training_title_ar' => 'الدورات التدريبية | رؤى محمود',
            'training_title_en' => 'Training | Rouaa Mahmoud',
            'training_description_ar' => 'سلاسل تدريبية في المحاسبة العملية والزكاة والضريبة والتدقيق ودراسات الجدوى — 12 دورة من مدرّبة معتمدة TOT.',
            'training_description_en' => 'Training series in practical accounting, Zakat & tax, auditing and feasibility studies — 12 courses from a TOT-certified trainer.',

            'contact_title_ar' => 'تواصل معي | رؤى محمود',
            'contact_title_en' => 'Contact | Rouaa Mahmoud',
            'contact_description_ar' => 'تواصل مع رؤى محمود عبر البريد أو الهاتف أو واتساب للاستشارات المالية والزكوية والتدريب المهني في الرياض.',
            'contact_description_en' => 'Get in touch with Rouaa Mahmoud by email, phone or WhatsApp for financial & Zakat consulting and professional training in Riyadh.',
        ];
    }

    /**
     * Image paths default to empty so image_url() falls back to the
     * config('portfolio.images.*') defaults (the extracted brand marks).
     * Uploading through the dashboard overwrites these with a public-disk path.
     *
     * @return array<string, mixed>
     */
    public static function images(): array
    {
        return [
            'logo' => '',
            'hero_logo' => '',
            'og' => '',
        ];
    }
}
