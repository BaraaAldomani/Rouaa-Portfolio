<?php

/**
 * Single source of truth for owner contact details, external links, and
 * default image paths. These are only fallbacks: every value here can be
 * overridden from the dashboard (settings table) and is read through
 * setting()/image_url(). Never hardcode these anywhere else.
 */
return [
    'email' => 'D1rouaa@gmail.com',

    // Digits only, international format — used to build the wa.me link.
    'whatsapp' => '966533632669',
    'phone_display' => '+966 53 363 2669',

    'location_en' => 'Riyadh, Saudi Arabia',
    'location_ar' => 'الرياض، المملكة العربية السعودية',

    'linkedin' => 'https://www.linkedin.com/in/rouaa-mahmoud',
    'youtube' => 'https://www.youtube.com/@RouaaMahmoud',

    /*
     * Imagery — single source of truth for image paths (under public/).
     * The two brand marks were extracted from the source design:
     *   logo — blue mark on transparent/white (nav, footer, light areas)
     *   hero — white mark on brand-blue (hero, dark/colored sections)
     */
    'images' => [
        'logo' => 'images/logo.jpg',
        'hero_logo' => 'images/hero.jpg',
        'og' => 'images/logo.jpg',
    ],
];
