<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class Stat extends Model
{
    use HasLocalizedContent;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'counter_target' => 'integer',
        ];
    }

    public function scopeContext(Builder $query, string $context): Builder
    {
        return $query->where('context', $context);
    }
}
