<?php

declare(strict_types=1);

namespace ServerGroups\Support;

/**
 * Works out which permissions every member should have on every server of their groups.
 */
final class Access
{
    /**
     * @param  list<array{servers: list<int>, members: list<array{user: int, permissions: list<string>}>}>  $groups
     * @param  array<int, int>  $owners  Server ids mapped to their owner's user id. Owners need no subuser.
     * @return array<string, list<string>> Sorted permissions keyed by "server:user".
     */
    public static function desired(array $groups, array $owners): array
    {
        $access = [];

        foreach ($groups as $group) {
            foreach ($group['servers'] as $server) {
                foreach ($group['members'] as $member) {
                    if (($owners[$server] ?? null) === $member['user']) {
                        continue;
                    }

                    $key = "{$server}:{$member['user']}";
                    $access[$key] = array_merge($access[$key] ?? [], $member['permissions']);
                }
            }
        }

        return array_map(static function (array $permissions): array {
            $permissions = array_values(array_unique($permissions));
            sort($permissions);

            return $permissions;
        }, $access);
    }
}
