<?php

namespace App\Http\Controllers;

use App\Support\Seo\PageMeta;
use Illuminate\View\View;

final class ServicesController
{
    public function __invoke(): View
    {
        return view('pages.services', [
            'meta' => PageMeta::fromLang('services'),
        ]);
    }
}
