<?php

declare(strict_types=1);

namespace ServerGroups\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Pterodactyl\Models\Server;

/**
 * @property int $id
 * @property string $name
 * @property string $color
 * @property Collection<int, Server> $servers
 * @property Collection<int, Member> $members
 */
final class Group extends Model
{
    protected $table = 'ext_server_groups_groups';

    protected $fillable = ['name', 'color'];

    /** @return BelongsToMany<Server, $this> */
    public function servers(): BelongsToMany
    {
        return $this->belongsToMany(Server::class, 'ext_server_groups_servers', 'group_id', 'server_id');
    }

    /** @return HasMany<Member, $this> */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}
