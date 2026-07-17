<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;

final class EducationItem extends Model
{
    use HasLocalizedContent;

    protected $guarded = [];
}
