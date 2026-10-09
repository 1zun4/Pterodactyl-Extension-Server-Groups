<?php

declare(strict_types=1);

namespace ServerGroups\Panel;

use Pterodactyl\Contracts\Subusers\CreatesSubusers;
use Pterodactyl\Contracts\Subusers\DeletesSubusers;
use Pterodactyl\Contracts\Subusers\UpdatesSubusers;
use Pterodactyl\Facades\Activity;
use Pterodactyl\Models\Server;
use Pterodactyl\Models\Subuser;
use Pterodactyl\Models\User;

/**
 * The only place this extension touches Panel internals.
 */
final readonly class Panel
{
    public function __construct(private CreatesSubusers $creator, private UpdatesSubusers $updater, private DeletesSubusers $deleter) {}

    /** @param list<string> $permissions */
    public function add(Server $server, User $user, array $permissions): Subuser
    {
        $subuser = $this->creator->create($server, $user->email, $permissions);
        Activity::event('server:subuser.create')->subject($server)->property(['email' => $user->email, 'permissions' => $permissions, 'via' => 'server-groups'])->log();

        return $subuser;
    }

    /** @param list<string> $permissions */
    public function update(Server $server, Subuser $subuser, array $permissions): void
    {
        $this->updater->update($server, $subuser, $permissions);
        Activity::event('server:subuser.update')->subject($server)->property(['email' => $subuser->user->email, 'permissions' => $permissions, 'via' => 'server-groups'])->log();
    }

    public function remove(Server $server, Subuser $subuser): void
    {
        $email = $subuser->user->email;
        $this->deleter->delete($server, $subuser);
        Activity::event('server:subuser.delete')->subject($server)->property(['email' => $email, 'via' => 'server-groups'])->log();
    }
}
