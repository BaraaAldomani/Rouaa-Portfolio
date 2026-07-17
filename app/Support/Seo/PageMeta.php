<?php

namespace App\Support\Seo;

use Illuminate\Support\Facades\Route;

final readonly class PageMeta
{
    /**
     * @param array<string, string> $alternates locale => absolute URL, used for hreflang + language switcher
     */
    public function __construct(
        public string $title,
        public string $description,
        public array $alternates,
        public string $canonical,
    ) {
    }

    /**
     * Build meta for a static page. Titles/descriptions come first from the
     * settings table (seo group), falling back to lang/{locale}/seo.php keys.
     */
    public static function fromLang(string $page): self
    {
        $alternates = self::alternatesFor(Route::currentRouteName(), []);

        return new self(
            title: setting_text("seo.{$page}_title", "seo.{$page}.title"),
            description: setting_text("seo.{$page}_description", "seo.{$page}.description"),
            alternates: $alternates,
            canonical: $alternates[app()->getLocale()],
        );
    }

    /**
     * @param array<string, string> $alternates
     * @return array<string, string>
     */
    private static function alternatesFor(string $routeName, array $paramsByLocale): array
    {
        return collect(config('app.supported_locales'))
            ->mapWithKeys(fn (string $locale) => [
                $locale => route($routeName, ['locale' => $locale, ...($paramsByLocale[$locale] ?? [])]),
            ])
            ->all();
    }
}
