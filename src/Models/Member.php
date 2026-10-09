<?php

declare(strict_types=1);

namespace ServerGroups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Pterodactyl\Models\User;

/**
 * @property int $group_id
 * @property int $user_id
 * @property list<string> $permissions
 * @property User $user
 */
final class Member extends Model
{
    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'ext_server_groups_members';

    protected $fillable = ['group_id', 'user_id', 'permissions'];

    protected function casts(): array
    {
        return ['permissions' => 'array'];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
