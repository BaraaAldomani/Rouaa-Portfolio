<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Course extends Model
{
    use HasLocalizedContent;

    protected $guarded = [];

    /**
     * @return BelongsTo<TrainingSeries, $this>
     */
    public function trainingSeries(): BelongsTo
    {
        return $this->belongsTo(TrainingSeries::class);
    }
}
