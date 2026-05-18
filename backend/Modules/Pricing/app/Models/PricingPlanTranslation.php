<?php

declare(strict_types=1);

namespace Modules\Pricing\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlanTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'features',
    ];
}
