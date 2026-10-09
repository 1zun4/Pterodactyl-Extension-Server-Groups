<?php

declare(strict_types=1);

namespace ServerGroups\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Pterodactyl\Models\Server;
use ServerGroups\Models\Group;

final class ClientController
{
    /** The groups of the servers the signed-in user can open. */
    public function index(Request $request): JsonResponse
    {
        $accessible = $request->user()->accessibleServers()->pluck('servers.id')->all();

        $groups = Group::query()
            ->whereHas('servers', static fn ($query) => $query->whereIn('servers.id', $accessible))
            ->with(['servers' => static fn ($query) => $query->whereIn('servers.id', $accessible)->orderBy('name')])
            ->orderBy('name')
            ->get();

        return new JsonResponse(['groups' => $groups->map(static fn (Group $group): array => [
            'id' => $group->id,
            'name' => $group->name,
            'color' => $group->color,
            'servers' => $group->servers->map(static fn (Server $server): array => [
                'identifier' => $server->uuidShort,
                'uuid' => $server->uuid,
                'name' => $server->name,
                'description' => $server->description,
            ])->values(),
        ])->values()]);
    }
}
