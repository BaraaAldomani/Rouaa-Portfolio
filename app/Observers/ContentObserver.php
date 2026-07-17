<?php

namespace App\Observers;

use App\Support\SiteContent;
use Illuminate\Database\Eloquent\Model;

/**
 * Invalidates the cached site content whenever any managed model changes,
 * so dashboard edits appear on the public site immediately.
 */
class ContentObserver
{
    public function saved(Model $model): void
    {
        app(SiteContent::class)->flush();
    }

    public function deleted(Model $model): void
    {
        app(SiteContent::class)->flush();
    }
}
