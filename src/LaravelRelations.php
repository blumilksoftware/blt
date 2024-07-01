<?php

declare(strict_types=1);

namespace Blumilk\BLT;

class LaravelRelations
{
    public const HAS_MANY = 'Illuminate\Database\Eloquent\Relations\HasMany';
    public const BELONGS_TO = 'Illuminate\Database\Eloquent\Relations\BelongsTo';
    public const HAS_ONE = 'Illuminate\Database\Eloquent\Relations\HasOne';
    public const BELONGS_TO_MANY = 'Illuminate\Database\Eloquent\Relations\BelongsToMany';
}
