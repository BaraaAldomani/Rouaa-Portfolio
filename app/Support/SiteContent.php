<?php

namespace App\Support;

use App\Models\EducationItem;
use App\Models\Experience;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\Stat;
use App\Models\TrainingSeries;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Throwable;

/**
 * Single read layer for all dashboard-managed content. Blade and controllers
 * read structural content through this service ($site in every view).
 *
 * The settings map (a plain array) is cached persistently. The content
 * collections are memoised per request only — they are small, indexed tables,
 * and Eloquent collections do not round-trip cleanly through the database
 * cache store (they deserialize as __PHP_Incomplete_Class). flush() clears the
 * settings cache; the ContentObserver calls it on save, so the next public
 * request re-reads fresh data.
 */
class SiteContent
{
    /** @var array<string, Collection<int, \Illuminate\Database\Eloquent\Model>> */
    private array $memo = [];

    /**
     * Whole settings map keyed as "group.key" => value.
     *
     * @return array<string, mixed>
     */
    public function settings(): array
    {
        return Cache::rememberForever('site:settings', function (): array {
            try {
                return Setting::all()
                    ->mapWithKeys(fn (Setting $s): array => ["{$s->group}.{$s->key}" => $s->value])
                    ->all();
            } catch (Throwable) {
                // Table may not exist yet (e.g. during initial migrate).
                return [];
            }
        });
    }

    public function setting(string $key, mixed $default = null): mixed
    {
        return $this->settings()[$key] ?? $default;
    }

    /** @return Collection<int, Service> */
    public function services(): Collection
    {
        return $this->remember('services', fn () => Service::ordered()->get());
    }

    /** @return Collection<int, TrainingSeries> */
    public function trainingSeries(): Collection
    {
        return $this->remember('training_series', fn () => TrainingSeries::with(['courses' => fn ($q) => $q->ordered()])->ordered()->get());
    }

    /** @return Collection<int, Experience> */
    public function experiences(): Collection
    {
        return $this->remember('experiences', fn () => Experience::ordered()->get());
    }

    /** @return Collection<int, EducationItem> */
    public function education(): Collection
    {
        return $this->remember('education', fn () => EducationItem::ordered()->get());
    }

    /** @return Collection<int, Skill> */
    public function skills(): Collection
    {
        return $this->remember('skills', fn () => Skill::ordered()->get());
    }

    /** @return Collection<int, Stat> */
    public function stats(string $context = 'hero'): Collection
    {
        return $this->remember("stats.{$context}", fn () => Stat::context($context)->ordered()->get());
    }

    public function flush(): void
    {
        Cache::forget('site:settings');
        $this->memo = [];
    }

    /**
     * Per-request memoisation for a content collection.
     *
     * @param  Closure(): Collection<int, \Illuminate\Database\Eloquent\Model>  $query
     * @return Collection<int, \Illuminate\Database\Eloquent\Model>
     */
    private function remember(string $key, Closure $query): Collection
    {
        return $this->memo[$key] ??= $query();
    }
}
