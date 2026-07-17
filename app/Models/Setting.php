<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Setting extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        // The "array" cast json_encodes on write and json_decodes on read,
        // which also round-trips scalars (strings, ints) as valid JSON.
        return [
            'value' => 'array',
        ];
    }
}
