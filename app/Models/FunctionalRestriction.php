<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $key
 * @property bool $default_value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FunctionalRestriction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FunctionalRestriction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FunctionalRestriction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FunctionalRestriction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FunctionalRestriction whereDefaultValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FunctionalRestriction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FunctionalRestriction whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FunctionalRestriction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FunctionalRestriction whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class FunctionalRestriction extends Model
{
    protected $table = 'functional_restrictions';

    protected $fillable = [
        'name',
        'key',
        'default_value',
    ];

    protected function casts()
    {
        return [
            'default_value' => 'boolean',
        ];
    }
}
