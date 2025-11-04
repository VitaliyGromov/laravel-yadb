<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\PromocodeToUserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $user_id
 * @property string $promocode_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class PromocodeToUser extends Model
{
    /** @use HasFactory<PromocodeToUserFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'user_id',
        'promocode_id',
    ];
}
