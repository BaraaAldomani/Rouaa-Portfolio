<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

final class SitemapController
{
    /** Static routes that exist in every locale. */
    private const STATIC_ROUTES = ['home', 'about', 'services', 'training', 'contact'];

    public function index(): Response
    {
        return response()
            ->view('seo.sitemap', ['urls' => $this->urls()])
            ->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        return response()
            ->view('seo.robots', ['sitemap' => route('sitemap')])
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Each entry: ['loc' => url, 'alternates' => [locale => url]].
     *
     * @return array<int, array{loc: string, alternates: array<string, string>}>
     */
    private function urls(): array
    {
        $locales = config('app.supported_locales');
        $urls = [];

        foreach (self::STATIC_ROUTES as $name) {
            $alternates = [];
            foreach ($locales as $locale) {
                $alternates[$locale] = route($name, ['locale' => $locale]);
            }

            foreach ($locales as $locale) {
                $urls[] = ['loc' => $alternates[$locale], 'alternates' => $alternates];
            }
        }

        return $urls;
    }
}
