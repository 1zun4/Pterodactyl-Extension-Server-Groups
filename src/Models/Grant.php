<?php

declare(strict_types=1);

namespace ServerGroups\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $server_id
 * @property int $user_id
 * @property int $subuser_id
 * @property list<string> $permissions
 */
final class Grant extends Model
{
    public $incrementing = false;

    protected $table = 'ext_server_groups_grants';

    protected $primaryKey = 'server_id';

    protected $fillable = ['server_id', 'user_id', 'subuser_id', 'permissions'];

    protected function casts(): array
    {
        return ['permissions' => 'array'];
    }
}
