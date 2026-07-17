<?php

namespace App\Http\Controllers;

use App\Support\Seo\PageMeta;
use Illuminate\View\View;

final class HomeController
{
    public function __invoke(): View
    {
        return view('pages.home', [
            'meta' => PageMeta::fromLang('home'),
        ]);
    }
}
