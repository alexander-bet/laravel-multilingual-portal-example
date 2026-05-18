<?php

declare(strict_types=1);

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Services\Models\Service;

class Lead extends Model
{
    use HasFactory;

    protected static function newFactory(): \Modules\Contact\Database\Factories\LeadFactory
    {
        return \Modules\Contact\Database\Factories\LeadFactory::new();
    }

    protected $table = 'contact_leads';

    protected $fillable = [
        'service_id',
        'email',
        'phone',
        'phone_country_code',
        'locale',
        'source',
        'status',
        'ip',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
