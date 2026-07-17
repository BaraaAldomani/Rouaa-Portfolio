<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use App\Support\Seo\PageMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class ContactController
{
    public function show(): View
    {
        return view('pages.contact', [
            'meta' => PageMeta::fromLang('contact'),
        ]);
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        ContactMessage::create([
            ...$request->safe()->only(['name', 'email', 'message']),
            'locale' => app()->getLocale(),
            'ip' => $request->ip(),
        ]);

        return back()->with('contact_sent', true);
    }
}
