<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\EducationItem;
use App\Models\Experience;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\Stat;
use App\Models\TrainingSeries;
use App\Observers\ContentObserver;
use App\Support\SiteContent;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Content models whose changes should bust the site content cache.
     */
    private const CONTENT_MODELS = [
        Service::class,
        TrainingSeries::class,
        Course::class,
        Experience::class,
        EducationItem::class,
        Skill::class,
        Stat::class,
        Setting::class,
    ];

    public function register(): void
    {
        $this->app->singleton(SiteContent::class);
    }

    public function boot(): void
    {
        foreach (self::CONTENT_MODELS as $model) {
            $model::observe(ContentObserver::class);
        }

        // Make the cached content service available to every view as $site.
        View::share('site', $this->app->make(SiteContent::class));
    }
}
