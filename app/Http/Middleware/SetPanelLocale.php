<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The public site defaults to Arabic, but the admin panel renders in a
 * fixed English/LTR chrome for a predictable editing experience. Bilingual
 * content is still edited through side-by-side Arabic/English fields.
 */
class SetPanelLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale('en');

        return $next($request);
    }
}
