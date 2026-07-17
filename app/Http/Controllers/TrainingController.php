<?php

namespace App\Http\Controllers;

use App\Support\Seo\PageMeta;
use Illuminate\View\View;

final class TrainingController
{
    public function __invoke(): View
    {
        return view('pages.training', [
            'meta' => PageMeta::fromLang('training'),
        ]);
    }
}
