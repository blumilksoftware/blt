<?php

declare(strict_types=1);

namespace Blumilk\BLT;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LaravelRelations
{
    public const HAS_MANY = HasMany::class;
    public const BELONGS_TO = BelongsTo::class;
    public const HAS_ONE = HasOne::class;
    public const BELONGS_TO_MANY = BelongsToMany::class;
}
