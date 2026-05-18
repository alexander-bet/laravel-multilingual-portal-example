<?php

declare(strict_types=1);

namespace Modules\Personnel\Models;

use Illuminate\Database\Eloquent\Model;

class PersonnelTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'position',
    ];
}
