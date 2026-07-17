<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * Shared behaviour for bilingual content models that follow the
 * `{field}_ar` / `{field}_en` column convention plus a `sort_order`
 * column. Reused across every dashboard-managed content type.
 */
trait HasLocalizedContent
{
    /**
     * Value of a bilingual column ("title", "summary", …) in the current locale.
     */
    public function localized(string $field): string
    {
        return (string) ($this->{$field . '_' . app()->getLocale()} ?? '');
    }

    /**
     * Value of a bilingual JSON/array column ("features", "points", …) in the current locale.
     *
     * @return array<int, string>
     */
    public function localizedArray(string $field): array
    {
        return $this->{$field . '_' . app()->getLocale()} ?? [];
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
