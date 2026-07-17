<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

final class Service extends Model
{
    use HasLocalizedContent;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'features_ar' => 'array',
            'features_en' => 'array',
        ];
    }

    /**
     * @return array<int, string>
     */
    public function features(): array
    {
        return $this->localizedArray('features');
    }
}
