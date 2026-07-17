<?php

namespace App\Http\Controllers;

use App\Support\Seo\PageMeta;
use Illuminate\View\View;

final class AboutController
{
    public function __invoke(): View
    {
        return view('pages.about', [
            'meta' => PageMeta::fromLang('about'),
        ]);
    }
}
