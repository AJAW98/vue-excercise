<?php

namespace App\Models;

use Database\Factories\OwnerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\AuthorityDocument
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static OwnerFactory factory(...$parameters)
 */

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
    ];

    /**
     * Get addresses associated with an owner.
     *
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get cars associated with an owner.
     *
     * @return HasMany
     */
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
