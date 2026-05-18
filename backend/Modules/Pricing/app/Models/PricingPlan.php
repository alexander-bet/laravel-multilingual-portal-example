<?php

declare(strict_types=1);

namespace Modules\Pricing\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslatableAdminAttributes;

class PricingPlan extends Model
{
    use Translatable, HasTranslatableAdminAttributes {
        HasTranslatableAdminAttributes::getAttribute insteadof Translatable;
        HasTranslatableAdminAttributes::setAttribute insteadof Translatable;
        Translatable::getAttribute as translatableGetAttribute;
        Translatable::setAttribute as translatableSetAttribute;
    }

    protected $table = 'pricing_plans';

    public array $translatedAttributes = [
        'name',
        'features',
    ];

    protected $fillable = [
        'price',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Parse features text (newline-separated) into an array.
     */
    public function featuresArray(): array
    {
        return array_values(array_filter(
            array_map('trim', explode("\n", $this->features ?? ''))
        ));
    }
}
